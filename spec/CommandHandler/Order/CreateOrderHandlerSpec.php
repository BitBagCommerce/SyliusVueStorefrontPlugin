<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\Order\CreateOrder;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order\CreateOrderHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\AddressInformation;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\OrderAddress;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\Product;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\AddressFactoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use SM\StateMachine\StateMachineInterface;
use Sylius\Bundle\PromotionBundle\Doctrine\ORM\PromotionCouponRepository;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\PromotionCouponInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateOrderHandlerSpec extends ObjectBehavior
{
    function let(
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
    ): void {
        $this->beConstructedWith(
            $cartRepository,
            $addressFactory,
            $stateMachineFactory,
            $customerRepository,
            $customerFactory,
            $paymentMethodRepository,
            $session,
            $objectPersister,
            $entityManager,
            $couponRepository,
            $couponEligibilityChecker,
            $translator
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateOrderHandler::class);
    }

    function it_creates_order_including_customer(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        PaymentInterface $payment,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );

        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn($customer);

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn($payment);

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_creates_order_matching_customer_by_email(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        CustomerRepositoryInterface $customerRepository,
        PaymentInterface $payment,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn(null);

        $customerRepository->findOneBy(['email' => 'customer@email.com'])->shouldBeCalledOnce()
            ->willReturn($customer);

        $cart->setCustomer($customer)->shouldBeCalledOnce();

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn($payment);

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_creates_order_creating_new_customer(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        PaymentInterface $payment,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn(null);

        $customerRepository->findOneBy(['email' => 'customer@email.com'])->shouldBeCalledOnce()
            ->willReturn(null);

        $customerFactory->createNew()->shouldBeCalledOnce()
            ->willReturn($customer);

        $customerRepository->add($customer)->shouldBeCalledOnce();

        $customer->setEmail($createOrder->addressInformation()->getBillingAddress()->getEmail())->shouldBeCalledOnce();

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn($payment);

        $cart->setCustomer($customer)->shouldBeCalledOnce();

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_changes_payment_method_before_creating_order(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        PaymentInterface $payment,
        PaymentMethodInterface $paypalPaymentMethod,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn(null);

        $customerRepository->findOneBy(['email' => 'customer@email.com'])->shouldBeCalledOnce()
            ->willReturn(null);

        $customerFactory->createNew()->shouldBeCalledOnce()
            ->willReturn($customer);

        $customerRepository->add($customer)->shouldBeCalledOnce();

        $customer->setEmail($createOrder->addressInformation()->getBillingAddress()->getEmail())->shouldBeCalledOnce();

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn($payment);

        $paymentMethodRepository->findOneBy(['code' => 'paypal'])->shouldBeCalledOnce()
            ->willReturn($paypalPaymentMethod);

        $payment->setMethod($paypalPaymentMethod)->shouldBeCalledOnce();

        $cart->setCustomer($customer)->shouldBeCalledOnce();

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_changes_payment_method_before_creating_order_but_there_is_no_last_payment(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn(null);

        $customerRepository->findOneBy(['email' => 'customer@email.com'])->shouldBeCalledOnce()
            ->willReturn(null);

        $customerFactory->createNew()->shouldBeCalledOnce()
            ->willReturn($customer);

        $customerRepository->add($customer)->shouldBeCalledOnce();

        $customer->setEmail($createOrder->addressInformation()->getBillingAddress()->getEmail())->shouldBeCalledOnce();

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn(null);

        $cart->setCustomer($customer)->shouldBeCalledOnce();

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_changes_payment_method_before_creating_order_but_new_method_was_not_found(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        PaymentInterface $payment,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        ProductInterface $product,
        ObjectPersisterInterface $objectPersister
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getProduct()->shouldBeCalledOnce()
            ->willReturn($product);

        $objectPersister->replaceOne($product)->shouldBeCalledOnce();

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn(null);

        $customerRepository->findOneBy(['email' => 'customer@email.com'])->shouldBeCalledOnce()
            ->willReturn(null);

        $customerFactory->createNew()->shouldBeCalledOnce()
            ->willReturn($customer);

        $customerRepository->add($customer)->shouldBeCalledOnce();

        $customer->setEmail($createOrder->addressInformation()->getBillingAddress()->getEmail())->shouldBeCalledOnce();

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cart->getLastPayment()->shouldBeCalledOnce()
            ->willReturn($payment);

        $paymentMethodRepository->findOneBy(['code' => 'paypal'])->shouldBeCalledOnce()
            ->willReturn(null);

        $cart->setCustomer($customer)->shouldBeCalledOnce();

        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }

    function it_validates_out_promotion_coupon_used_more_than_once_but_it_can_be_used_only_once(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressFactoryInterface $addressFactory,
        AddressInterface $address,
        OrderItemInterface $orderItem,
        ProductVariantInterface $productVariant,
        PromotionCouponInterface $promotionCoupon,
        PromotionCouponEligibilityCheckerInterface $couponEligibilityChecker
    ): void {
        $cart->getItems()->shouldBeCalled()
            ->willReturn(new ArrayCollection([$orderItem->getWrappedObject()]));

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn(null);

        $orderItem->getVariant()->shouldBeCalledOnce()
            ->willReturn($productVariant);

        $orderItem->getQuantity()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHand()->shouldBeCalledOnce()
            ->willReturn(1);

        $productVariant->getOnHold()->shouldBeCalledOnce()
            ->willReturn(0);

        $productVariant->isTracked()->shouldBeCalledOnce()
            ->willReturn(true);

        $cart->getPromotionCoupon()->shouldBeCalled()
            ->willReturn($promotionCoupon);

        $couponEligibilityChecker->isEligible($cart, $promotionCoupon)->shouldBeCalled()
            ->willReturn(false);

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );

        $addressFactory->createFromDTO(Argument::any())->willReturn($address);

        $customer->setFirstName($createOrder->addressInformation()->getBillingAddress()->getFirstName())
            ->shouldBeCalledOnce()
        ;

        $customer->setLastName($createOrder->addressInformation()->getBillingAddress()->getLastName())
            ->shouldBeCalledOnce()
        ;

        $customer->setPhoneNumber($createOrder->addressInformation()->getBillingAddress()->getPhoneNumber())
            ->shouldBeCalledOnce()
        ;

        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn($customer);

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$createOrder]);
    }

    function it_throws_exception_if_there_are_no_items_in_the_cart(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart
    ): void {
        $cart->getItems()->willReturn(new ArrayCollection([]));

        $orderAddress = new OrderAddress();
        $orderAddress->email = 'customer@email.com';
        $orderAddress->firstname = 'John';
        $orderAddress->lastname = 'Doe';
        $orderAddress->telephone = '987654321';

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;
        $addressInformation->payment_method_code = 'paypal';

        $product = new Product();

        $createOrder = new CreateOrder(
            '12345',
            $addressInformation,
            $product
        );

        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$createOrder]);
    }
}
