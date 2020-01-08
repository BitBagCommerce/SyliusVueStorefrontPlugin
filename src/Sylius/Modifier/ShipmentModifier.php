<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final class ShipmentModifier implements ShipmentModifierInterface
{
    public function modify(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void
    {
        Assert::lessThanEq($cart->getShipments()->count(), 1, sprintf('More than one shipment is currently unsupported.'));

        /** @var ShipmentInterface $shipment */
        $shipment = $cart->getShipments()->first();

        $shipment->setState(Shipment::STATE_CART);
        $shipment->setMethod($shippingMethod);
    }
}
