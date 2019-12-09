<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order;

use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order\CreateOrderHandler;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class CreateOrderHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CreateOrderHandler::class);
    }
}
