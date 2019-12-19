<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

interface ShipmentProviderInterface
{
    public function provide(ShippingMethodInterface $shippingMethod): ShipmentInterface;
}
