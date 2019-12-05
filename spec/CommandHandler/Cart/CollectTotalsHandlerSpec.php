<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\CollectTotalsHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 * Class CollectTotalsHandlerSpec
 * @package spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart
 */
class CollectTotalsHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CollectTotalsHandler::class);
    }
}
