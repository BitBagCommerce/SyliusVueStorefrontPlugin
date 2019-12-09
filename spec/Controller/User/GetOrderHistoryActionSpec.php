<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\GetOrderHistoryAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class GetOrderHistoryActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetOrderHistoryAction::class);
    }
}
