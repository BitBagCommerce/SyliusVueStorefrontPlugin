<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

interface AdjustmentModifierInterface
{
    public function modify(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void;
}
