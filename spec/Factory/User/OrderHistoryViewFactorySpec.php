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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class OrderHistoryViewFactorySpec extends ObjectBehavior
{
    function let(OrderViewFactoryInterface $orderViewFactory, OrderRepositoryInterface $orderRepository): void
    {
        $this->beConstructedWith(OrderHistoryView::class, $orderViewFactory, $orderRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(OrderHistoryViewFactory::class);
    }

    function it_creates_order_factory_view(
        OrderViewFactoryInterface $orderViewFactory,
        OrderRepositoryInterface $orderRepository,
        CustomerInterface $customer,
        OrderInterface $order
    ): void {
        $orderView = new OrderView();

        $orderRepository->findBy(['customer' => $customer, 'checkoutState' => 'completed'])->willReturn([$order]);

        $orderViewFactory->createList([$order])->willReturn([$orderView]);

        $this->create($customer, new PaginationParameters((string) 21, (string) 1))->shouldReturnAnInstanceOf(OrderHistoryView::class);
    }
}
