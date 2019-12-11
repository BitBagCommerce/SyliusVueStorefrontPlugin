<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingMethods;
use PhpSpec\ObjectBehavior;

final class SetShippingMethodsSpec extends ObjectBehavior
{
    private const TOKEN = 'token';
    private const CART_ID = 'set-shipping-methods-spec';
    private const ADDRESS = null;

    function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN,
            self::CART_ID,
            self::ADDRESS
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SetShippingMethods::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
        $this->cartId()->shouldReturn(self::CART_ID);
        $this->address()->shouldReturn(self::ADDRESS);
    }
}
