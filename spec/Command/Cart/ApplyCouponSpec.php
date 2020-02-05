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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\ApplyCoupon;
use PhpSpec\ObjectBehavior;

final class ApplyCouponSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('token', 'cart-id', 'coupon');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ApplyCoupon::class);
    }

    function it_allows_to_access_properties_via_getters(): void
    {
        $this->token()->shouldReturn('token');
        $this->cartId()->shouldReturn('cart-id');
        $this->coupon()->shouldReturn('coupon');
    }
}
