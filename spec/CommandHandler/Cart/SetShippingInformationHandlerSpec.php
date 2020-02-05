<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\SetShippingInformationHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Handler\ShipmentHandlerInterface;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\AddressInformation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;

final class SetShippingInformationHandlerSpec extends ObjectBehavior
{
    function let(
        OrderRepositoryInterface $orderRepository,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        ShipmentHandlerInterface $shipmentHandler
    ): void {
        $this->beConstructedWith($orderRepository, $shippingMethodRepository, $shipmentHandler);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SetShippingInformationHandler::class);
    }

    function it_handles_setting_shipping_information(
        OrderRepositoryInterface $orderRepository,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        OrderInterface $cart,
        ShippingMethodInterface $shippingMethod,
        ShipmentHandlerInterface $shipmentHandler
    ): void {
        $addressInformation = new AddressInformation();
        $addressInformation->shipping_carrier_code = 'carrier_code';

        $setShippingInformation = new SetShippingInformation('token', 'cart-id', $addressInformation);

        $orderRepository->findOneBy([
            'tokenValue' => 'cart-id',
            'shippingState' => 'cart',
        ])->willReturn($cart);

        $shippingMethodRepository->findOneBy([
            'code' => 'carrier_code',
            'enabled' => 1,
        ])->willReturn($shippingMethod);

        $shipmentHandler->handle($cart, $shippingMethod)->shouldBeCalled();

        $this->__invoke($setShippingInformation);
    }

    function it_throws_exception_when_cart_is_not_found(OrderRepositoryInterface $orderRepository): void
    {
        $addressInformation = new AddressInformation();

        $setShippingInformation = new SetShippingInformation('token', 'invalid-cart-id', $addressInformation);

        $orderRepository->findOneBy(Argument::any())->willReturn(null);

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$setShippingInformation]);
    }
}
