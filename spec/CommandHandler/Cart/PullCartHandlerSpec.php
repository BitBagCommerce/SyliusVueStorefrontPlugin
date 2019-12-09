<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\PullCartHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class PullCartHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PullCartHandler::class);
    }
}
