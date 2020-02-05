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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\AddressProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use SM\StateMachine\StateMachineInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class CreateOrderHandlerSpec extends ObjectBehavior
{
    function let(
        OrderRepositoryInterface $cartRepository,
        AddressProviderInterface $addressProvider,
        StateMachineFactoryInterface $stateMachineFactory
    ): void {
        $this->beConstructedWith($cartRepository, $addressProvider, $stateMachineFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrderHandler::class);
    }

    function it_creates_order(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        CustomerInterface $customer,
        AddressProviderInterface $addressProvider,
        AddressInterface $address,
        StateMachineFactoryInterface $stateMachineFactory,
        StateMachineInterface $stateMachine
    ): void {
        $orderAddress = new OrderAddress();

        $addressInformation = new AddressInformation();
        $addressInformation->shippingAddress = $orderAddress;
        $addressInformation->billingAddress = $orderAddress;

        $product = new Product();

        $createOrder = new CreateOrder('12345', $addressInformation, $product);
        $cartRepository->findOneBy(Argument::any())->willReturn($cart);

        $cart->getCustomer()->willReturn($customer);
        $cart->getTokenValue()->willReturn('12345');

        $cart->setShippingAddress($address)->shouldBeCalled();
        $cart->setBillingAddress($address)->shouldBeCalled();

        $addressProvider->provide(Argument::any())->willReturn($address);

        $stateMachineFactory->get($cart, OrderCheckoutTransitions::GRAPH)->willReturn($stateMachine);
        $stateMachine->can(Argument::any())->willReturn(true);
        $stateMachine->apply(Argument::any())->shouldBeCalled();

        $cart->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->__invoke($createOrder);
    }
}
