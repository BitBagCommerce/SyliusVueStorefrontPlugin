<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

interface ShipmentModifierInterface
{
    public function modify(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void;
}
