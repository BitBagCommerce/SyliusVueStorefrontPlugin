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

interface ShippingAssignmentViewFactoryInteface
{
    public function create(OrderInterface $syliusOrder): ShippingAssignmentView;

    public function createList(array $syliusOrders): array;
}
