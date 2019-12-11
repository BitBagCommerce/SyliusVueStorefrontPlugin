<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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
