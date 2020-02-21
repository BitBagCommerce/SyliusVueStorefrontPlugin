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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\OrderCheckoutStates;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class OrderHistoryViewFactory implements OrderHistoryViewFactoryInterface
{
    /** @var string */
    private $orderHistoryViewClass;

    /** @var OrderViewFactoryInterface */
    private $orderViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        string $orderHistoryViewClass,
        OrderViewFactoryInterface $orderViewFactory,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderHistoryViewClass = $orderHistoryViewClass;
        $this->orderViewFactory = $orderViewFactory;
        $this->orderRepository = $orderRepository;
    }

    public function create(CustomerInterface $syliusCustomer, PaginationParameters $paginationParameters): OrderHistoryView
    {
        /** @var OrderHistoryView $orderHistoryView */
        $orderHistoryView = new $this->orderHistoryViewClass();

        $customerOrders = $this->orderRepository->findBy([
            'customer' => $syliusCustomer,
            'checkoutState' => OrderCheckoutStates::STATE_COMPLETED,
        ]);

        $paginatedOrders = (new Pagerfanta(new ArrayAdapter($customerOrders)))
            ->setMaxPerPage($paginationParameters->getPageSize())
            ->setCurrentPage($paginationParameters->getCurrentPage())
            ->getCurrentPageResults();

        $orderHistoryView->items = $this->orderViewFactory->createList($paginatedOrders);
        $orderHistoryView->total_count = count($customerOrders);

        return $orderHistoryView;
    }
}
