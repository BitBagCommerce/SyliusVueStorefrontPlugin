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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\CreateCartHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\CartFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class CreateCartHandlerSpec extends ObjectBehavior
{
    function let(
        CartFactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider
    ): void {
        $this->beConstructedWith($cartFactory, $cartRepository, $channelProvider, $customerProvider);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateCartHandler::class);
    }

    function it_creates_cart_for_guest_user(
        CartFactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        ChannelInterface $channel
    ): void {
        $createCart = new CreateCart();
        $createCart->setCartId('cart-id');

        $channelProvider->provide()->willReturn($channel);

        $customerProvider->provide('cart-id')->willReturn(null);

        $cartFactory->createForChannel($channel)->willReturn($cart);

        $cart->setState(OrderInterface::STATE_CART)->shouldBeCalledOnce();
        $cart->setPaymentState(OrderInterface::STATE_CART)->shouldBeCalledOnce();

        $cart->setTokenValue('cart-id')->shouldBeCalled();

        $cartRepository->add($cart)->shouldBeCalled();

        $this->__invoke($createCart);
    }

    function it_attaches_previous_cart_to_existing_shop_user(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        ChannelInterface $channel,
        CustomerInterface $customer
    ): void {
        $createCart = new CreateCart();
        $createCart->setCartId('cart-id');

        $customer->getEmail()->willReturn('shop_user@shop.com');

        $channelProvider->provide()->willReturn($channel);

        $customerProvider->provide('cart-id')->willReturn($customer);

        $cartRepository->findLatestCartByChannelAndCustomer($channel, $customer)->willReturn($cart);

        $cart->setTokenValue('cart-id')->shouldBeCalled();

        $this->__invoke($createCart);
    }

    function it_creates_cart_for_existing_shop_user(
        CartFactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        ChannelInterface $channel,
        CustomerInterface $customer
    ): void {
        $createCart = new CreateCart();
        $createCart->setCartId('cart-id');

        $customer->getEmail()->willReturn('shop_user@shop.com');

        $channelProvider->provide()->willReturn($channel);

        $customerProvider->provide('cart-id')->willReturn($customer);

        $cartRepository->findLatestCartByChannelAndCustomer($channel, $customer)->willReturn(null);

        $cartFactory->createForCustomerAndChannel($customer, $channel)->willReturn($cart);

        $cart->setState(OrderInterface::STATE_CART)->shouldBeCalledOnce();
        $cart->setPaymentState(OrderInterface::STATE_CART)->shouldBeCalledOnce();

        $cartRepository->add($cart);

        $cart->setTokenValue('cart-id')->shouldBeCalled();

        $this->__invoke($createCart);
    }
}
