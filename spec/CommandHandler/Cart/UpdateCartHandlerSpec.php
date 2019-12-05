<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\UpdateCartHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
class UpdateCartHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateCartHandler::class);
    }
}
