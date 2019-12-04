<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\PullCartHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
class PullCartHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PullCartHandler::class);
    }
}
