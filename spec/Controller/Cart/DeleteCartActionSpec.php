<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\DeleteCartAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class DeleteCartActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(DeleteCartAction::class);
    }
}
