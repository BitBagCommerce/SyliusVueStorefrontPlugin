<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\ApplyCouponHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 * Class ApplyCouponHandlerSpec
 * @package spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart
 */
class ApplyCouponHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ApplyCouponHandler::class);
    }
}
