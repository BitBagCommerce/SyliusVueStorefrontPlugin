<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\SyncTotalsAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class SyncTotalsActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyncTotalsAction::class);
    }
}
