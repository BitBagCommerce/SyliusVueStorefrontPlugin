<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ShipmentProvider implements ShipmentProviderInterface
{
    /** @var FactoryInterface */
    private $shipmentFactory;

    public function __construct(FactoryInterface $shipmentFactory)
    {
        $this->shipmentFactory = $shipmentFactory;
    }

    public function provide(ShippingMethodInterface $shippingMethod): ShipmentInterface
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $this->shipmentFactory->createNew();
        $shipment->setState(Shipment::STATE_CART);
        $shipment->setMethod($shippingMethod);

        return $shipment;
    }
}
