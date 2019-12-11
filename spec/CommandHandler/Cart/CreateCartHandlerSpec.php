<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\CreateCartHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CreateCartHandlerSpec extends ObjectBehavior
{
    function let(
        FactoryInterface $cartFactory,
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

    function it_creates_cart(
        FactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        ChannelInterface $channel,
        CustomerInterface $customer,
        CurrencyInterface $currency,
        LocaleInterface $locale
    ): void {
        $createCart = new CreateCart('token', 'cart-id');

        $channel->getBaseCurrency()->willReturn($currency);
        $channel->getDefaultLocale()->willReturn($locale);

        $channelProvider->provide()->willReturn($channel);

        $customerProvider->provide('cart-id')->willReturn($customer);

        $cartFactory->createNew()->willReturn($cart);

        $cartRepository->add($cart)->shouldBeCalled();

        $this->__invoke($createCart);
    }
}
