<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\Order\CreateOrder;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\AddressFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Bundle\PromotionBundle\Doctrine\ORM\PromotionCouponRepository;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class CreateOrderHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var AddressFactoryInterface */
    private $addressFactory;

    /** @var StateMachineFactoryInterface */
    private $stateMachineFactory;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var FactoryInterface */
    private $customerFactory;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    /** @var Session */
    private $session;

    /** @var ObjectPersisterInterface */
    private $objectPersister;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PromotionCouponRepository */
    private $couponRepository;

    /** @var PromotionCouponEligibilityCheckerInterface */
    private $couponEligibilityChecker;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(
        OrderRepositoryInterface $cartRepository,
        AddressFactoryInterface $addressFactory,
        StateMachineFactoryInterface $stateMachineFactory,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        Session $session,
        ObjectPersisterInterface $objectPersister,
        EntityManagerInterface $entityManager,
        PromotionCouponRepository $couponRepository,
        PromotionCouponEligibilityCheckerInterface $couponEligibilityChecker,
        TranslatorInterface $translator
    ) {
        $this->cartRepository = $cartRepository;
        $this->addressFactory = $addressFactory;
        $this->stateMachineFactory = $stateMachineFactory;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->session = $session;
        $this->objectPersister = $objectPersister;
        $this->entityManager = $entityManager;
        $this->couponRepository = $couponRepository;
        $this->couponEligibilityChecker = $couponEligibilityChecker;
        $this->translator = $translator;
    }

    public function __invoke(CreateOrder $createOrder): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy([
            'tokenValue' => $createOrder->cartId(),
            'shippingState' => OrderInterface::STATE_CART,
        ]);
        Assert::notNull($cart, sprintf('Cart with token value of %s has not been found.', $createOrder->cartId()));

        $items = $cart->getItems();

        Assert::greaterThan(
            $items->count(),
            0,
            'You cannot create an order with no items in the cart'
        );

        foreach ($items as $item) {
            $variant = $item->getVariant();
            if ($variant->isTracked() && $item->getQuantity() > $variant->getOnHand() - $variant->getOnHold()) {
                $variantName = $item->getVariantName();

                throw new \LogicException("We don't have as many \"$variantName\" as you requested.");
            }
        }

        /** @var CustomerInterface $customer */
        $customer = $cart->getCustomer();
        if ($customer === null) {
            $customer = $this->assignCustomer($createOrder, $cart);
        }

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName());
        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName());

        if ($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber() !== null) {
            $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber());
        }

        $this->entityManager->flush();

        if ($cart->getPromotionCoupon()) {
            Assert::true(
                $this->couponEligibilityChecker->isEligible($cart, $cart->getPromotionCoupon()),
                $this->translator->trans(
                    'bitbag.vue_storefront_api.sylius.cart.promotion_already_used',
                    ['code' => $cart->getPromotionCoupon()->getCode()],
                    'validators'
                )
            );
        }

        $this->handlePaymentChange($cart, $createOrder->addressInformation()->getPaymentMethodCode());

        $shippingAddress = $this->addressFactory->createFromDTO(
            $createOrder->addressInformation()->getShippingAddress()
        );
        $cart->setShippingAddress($shippingAddress);

        $billingAddress = $this->addressFactory->createFromDTO(
            $createOrder->addressInformation()->getBillingAddress()
        );
        $cart->setBillingAddress($billingAddress);

        $stateMachine = $this->stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH);

        Assert::true(
            $stateMachine->can(OrderCheckoutTransitions::TRANSITION_ADDRESS),
            sprintf('Order with %s token cannot be addressed.', $createOrder->cartId())
        );
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_ADDRESS);

        $canGoShipping = $stateMachine->can(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING);
        if ($canGoShipping) {
            $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING);
        }

        $canGoPayment = $stateMachine->can(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        if ($canGoPayment) {
            $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        }

        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);

        $cart->setCreatedAt(new \DateTime());

        $this->entityManager->flush();

        foreach ($cart->getItems() as $item) {
            $this->objectPersister->replaceOne($item->getProduct());
        }
    }

    private function assignCustomer(CreateOrder $createOrder, OrderInterface $cart): CustomerInterface
    {
        $email = $createOrder->addressInformation()->getBillingAddress()->getEmail();

        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy([
            'email' => $email,
        ]);

        if ($customer === null) {
            $customer = $this->customerFactory->createNew();
            $customer->setEmail($email);

            $this->customerRepository->add($customer);
        }

        $cart->setCustomer($customer);

        return $customer;
    }

    private function handlePaymentChange(OrderInterface $order, string $paymentMethodCode): void
    {
        $lastPayment = $order->getLastPayment();
        if (!$lastPayment) {
            return;
        }

        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $this->paymentMethodRepository->findOneBy(['code' => $paymentMethodCode]);

        if (null === $paymentMethod) {
            return;
        }

        $lastPayment->setMethod($paymentMethod);
    }
}
