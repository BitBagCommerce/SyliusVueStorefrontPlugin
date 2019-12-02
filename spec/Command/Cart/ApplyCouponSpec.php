<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\ApplyCoupon;
use PhpSpec\ObjectBehavior;

class ApplyCouponSpec extends ObjectBehavior
{
    private const TOKEN = 'token';
    private const CART_ID = "apply-coupon-spec";
    private const COUPON = 'coupon';

    function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN,
            self::CART_ID,
            self::COUPON
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ApplyCoupon::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
        $this->cartId()->shouldReturn(self::CART_ID);
        $this->coupon()->shouldReturn(self::COUPON);
    }
}
