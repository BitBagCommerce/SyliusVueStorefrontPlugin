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

use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistory\OrderViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistoryViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class OrderHistoryViewFactorySpec extends ObjectBehavior
{
    function let(OrderRepositoryInterface $orderRepository, OrderViewFactoryInterface $orderViewFactory): void
    {
        $this->beConstructedWith($orderRepository, $orderViewFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(OrderHistoryViewFactory::class);
    }

    function it_creates_order_factory_view(
        OrderRepositoryInterface $orderRepository,
        OrderViewFactoryInterface $orderViewFactory,
        CustomerInterface $customer,
        OrderInterface $order
    ): void {
        $orderView = new OrderView();

        $orderRepository->findByCustomer($customer)->willReturn([$order]);

        $orderViewFactory->createList([$order])->willReturn([$orderView]);

        $this->create($customer);
    }
}
