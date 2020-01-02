<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Order\Model\AdjustmentInterface;

interface AdjustmentProviderInterface
{
    public function provide(ShippingMethodInterface $shippingMethod): AdjustmentInterface;
}
