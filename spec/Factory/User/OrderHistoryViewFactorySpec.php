<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\User;

use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistoryViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use PhpSpec\ObjectBehavior;

final class OrderHistoryViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(OrderHistoryViewFactory::class);
    }

    function it_creates_order_factory_view(): void
    {
        $this->create()->shouldBeAnInstanceOf(OrderHistoryView::class);
    }
}
