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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier\DefaultAddressModifierInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\AddressProviderInterface;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class CreateOrderHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var AddressProviderInterface */
    private $addressProvider;

    /** @var DefaultAddressModifierInterface */
    private $addressModifier;

    /** @var StateMachineFactoryInterface */
    private $stateMachineFactory;

    public function __construct(
        OrderRepositoryInterface $cartRepository,
        AddressProviderInterface $addressProvider,
        DefaultAddressModifierInterface $addressModifier,
        StateMachineFactoryInterface $stateMachineFactory
    ) {
        $this->cartRepository = $cartRepository;
        $this->addressProvider = $addressProvider;
        $this->addressModifier = $addressModifier;
        $this->stateMachineFactory = $stateMachineFactory;
    }

    public function __invoke(CreateOrder $createOrder): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy(['tokenValue' => $createOrder->cartId(), 'shippingState' => OrderInterface::STATE_CART]);
        Assert::notNull($cart, sprintf('Cart with token value of %s has not been found.', $createOrder->cartId()));

        /** @var CustomerInterface $customer */
        $customer = $cart->getCustomer();
        Assert::notNull($customer, sprintf('Cart `%s` has no valid customer assigned.', $cart->getTokenValue()));

        $shippingAddress = $this->addressProvider->provide($customer, $createOrder->addressInformation()->getShippingAddress());
        $this->addressModifier->modify($customer, $shippingAddress);
        $cart->setShippingAddress($shippingAddress);

        $billingAddress = $this->addressProvider->provide($customer, $createOrder->addressInformation()->getBillingAddress());
        $cart->setBillingAddress($billingAddress);

        $stateMachine = $this->stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH);

        Assert::true(
            $stateMachine->can(OrderCheckoutTransitions::TRANSITION_ADDRESS),
            sprintf('Order with %s token cannot be addressed.', $createOrder->cartId())
        );
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_ADDRESS);

        Assert::true($stateMachine->can(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING), 'Order cannot have shipment method assigned.');
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING);

        Assert::true($stateMachine->can(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT), 'Order cannot have payment method assigned.');
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);

        Assert::true($stateMachine->can(OrderCheckoutTransitions::TRANSITION_COMPLETE), sprintf('Order with %s token cannot be completed.', $createOrder->cartId()));
        $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);
    }
}
