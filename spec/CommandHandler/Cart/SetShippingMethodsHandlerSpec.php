<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\SetShippingMethodsHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class SetShippingMethodsHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SetShippingMethodsHandler::class);
    }
}
