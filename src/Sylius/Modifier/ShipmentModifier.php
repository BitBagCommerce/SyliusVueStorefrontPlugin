<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final class ShipmentModifier implements ShipmentModifierInterface
{
    /** @var ObjectManager */
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function modify(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void
    {
        Assert::lessThanEq($cart->getShipments()->count(), 1, sprintf('More than one shipment is currently unsupported.'));

        /** @var ShipmentInterface $shipment */
        $shipment = $cart->getShipments()->first();

        $shipment->setState(Shipment::STATE_CART);
        $shipment->setMethod($shippingMethod);

        $this->entityManager->persist($shipment);
        $this->entityManager->flush();
    }
}
