<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\DeleteCouponHandler;
use PhpSpec\ObjectBehavior;

class DeleteCouponHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteCouponHandler::class);
    }
}
