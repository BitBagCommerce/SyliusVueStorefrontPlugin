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

use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderExtensionAttributesView;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderExtensionAttributesViewFactory implements OrderExtensionAttributesViewFactoryInterface
{
    /** @var string */
    private $orderExtensionAttributesViewClass;

    /** @var ShippingAssignmentViewFactoryInteface */
    private $shippingAssignmentViewFactoryInteface;

    public function __construct(
        string $orderExtensionAttributesViewClass,
        ShippingAssignmentViewFactoryInteface $shippingAssignmentViewFactoryInteface
    ) {
        $this->orderExtensionAttributesViewClass = $orderExtensionAttributesViewClass;
        $this->shippingAssignmentViewFactoryInteface = $shippingAssignmentViewFactoryInteface;
    }

    public function create(OrderInterface $syliusOrder): OrderExtensionAttributesView
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

    private function createFromOrder(OrderInterface $syliusOrder): OrderExtensionAttributesView
    {
        /** @var OrderExtensionAttributesView $orderExtensionAttributesView */
        $orderExtensionAttributesView = new $this->orderExtensionAttributesViewClass();
        $orderExtensionAttributesView->shipping_assignments = $this->shippingAssignmentViewFactoryInteface->createList([$syliusOrder]);

        return $orderExtensionAttributesView;
    }
}
