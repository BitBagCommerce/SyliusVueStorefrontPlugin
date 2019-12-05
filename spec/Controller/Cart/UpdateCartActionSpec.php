<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\UpdateCartAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
class UpdateCartActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateCartAction::class);
    }
}
