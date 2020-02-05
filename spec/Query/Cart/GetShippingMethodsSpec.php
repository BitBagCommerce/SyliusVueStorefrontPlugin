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

use BitBag\SyliusVueStorefrontPlugin\Query\Cart\GetShippingMethods;
use PhpSpec\ObjectBehavior;

final class GetShippingMethodsSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('token', 'set-shipping-methods-spec', null);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetShippingMethods::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn('token');
        $this->cartId()->shouldReturn('set-shipping-methods-spec');
        $this->address()->shouldReturn(null);
    }
}
