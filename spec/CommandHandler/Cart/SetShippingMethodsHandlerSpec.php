<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\SetShippingMethodsHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
class SetShippingMethodsHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SetShippingMethodsHandler::class);
    }
}
