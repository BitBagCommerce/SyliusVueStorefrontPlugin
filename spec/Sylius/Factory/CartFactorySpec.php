<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Factory;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\CartFactory;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class CartFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $cartFactory): void
    {
        $this->beConstructedWith($cartFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CartFactory::class);
    }

    function it_creates_cart(
        FactoryInterface $cartFactory,
        OrderInterface $cart,
        CustomerInterface $customer,
        ChannelInterface $channel,
        CurrencyInterface $currency,
        LocaleInterface $locale
    ): void {
        $cartFactory->createNew()->willReturn($cart);

        $currency->getCode()->willReturn('currency-code');
        $locale->getCode()->willReturn('locale-code');

        $channel->getBaseCurrency()->willReturn($currency);
        $channel->getDefaultLocale()->willReturn($locale);

        $cart->setCustomer($customer)->shouldBeCalled();
        $cart->setChannel($channel)->shouldBeCalled();
        $cart->setCurrencyCode('currency-code')->shouldBeCalled();
        $cart->setLocaleCode('locale-code')->shouldBeCalled();

        $this->createForCustomerAndChannel($customer, $channel);
    }
}
