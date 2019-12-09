<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\PullCartAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class PullCartActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PullCartAction::class);
    }
}
