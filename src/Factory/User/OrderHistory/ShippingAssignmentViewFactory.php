<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistory;

use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingAssignmentView;
use Sylius\Component\Core\Model\OrderInterface;

final class ShippingAssignmentViewFactory implements ShippingAssignmentViewFactoryInteface
{
    /** @var ShippingViewFactoryInterface */
    private $shippingViewFactory;

    public function __construct(ShippingViewFactoryInterface $shippingViewFactory)
    {
        $this->shippingViewFactory = $shippingViewFactory;
    }

    public function create(OrderInterface $syliusOrder): ShippingAssignmentView
    {
        return $this->createFromOrder($syliusOrder);
    }

    public function createList(array $syliusOrders): array
    {
        $ordersList = [];

        foreach ($syliusOrders as $syliusOrder) {
            $ordersList[] = $this->createFromOrder($syliusOrder);
        }

        return $ordersList;
    }

    private function createFromOrder(OrderInterface $syliusOrder): ShippingAssignmentView
    {
        $shippingAssignmentView = new ShippingAssignmentView();
        $shippingAssignmentView->shipping = $this->shippingViewFactory->create($syliusOrder);

        return $shippingAssignmentView;
    }
}
