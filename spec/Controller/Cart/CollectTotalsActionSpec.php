<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\CollectTotalsAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
class CollectTotalsActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectTotalsAction::class);
    }
}
