<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Stock;

use BitBag\SyliusVueStorefrontPlugin\Controller\Stock\CheckStockAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class CheckStockActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CheckStockAction::class);
    }
}
