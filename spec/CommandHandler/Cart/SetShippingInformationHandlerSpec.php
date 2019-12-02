<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\SetShippingInformationHandler;
use PhpSpec\ObjectBehavior;

class SetShippingInformationHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SetShippingInformationHandler::class);
    }
}
