<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\User;

use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistory\OrderViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class OrderHistoryViewFactory implements OrderHistoryViewFactoryInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var OrderViewFactoryInterface */
    private $orderViewFactory;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderViewFactoryInterface $orderViewFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderViewFactory = $orderViewFactory;
    }

    public function create(CustomerInterface $syliusCustomer): OrderHistoryView
    {
        $orderHistoryView = new OrderHistoryView();

        $customerOrders = $this->orderRepository->findByCustomer($syliusCustomer);

        $orderHistoryView->items = $this->orderViewFactory->createList($customerOrders);
        $orderHistoryView->total_count = count($customerOrders);
        $orderHistoryView->search_criteria = [];

        return $orderHistoryView;
    }
}
