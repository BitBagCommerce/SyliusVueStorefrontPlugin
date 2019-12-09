<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\SetShippingInformationHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class SetShippingInformationHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SetShippingInformationHandler::class);
    }
}
