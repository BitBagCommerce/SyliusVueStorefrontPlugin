<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Handler;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

interface ShipmentHandlerInterface
{
    public function handle(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void;
}
