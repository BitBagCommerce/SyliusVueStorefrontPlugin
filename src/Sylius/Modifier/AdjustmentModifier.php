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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\AdjustmentProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final class AdjustmentModifier implements AdjustmentModifierInterface
{
    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var AdjustmentProviderInterface */
    private $adjustmentProvider;

    public function __construct(
        ChannelProviderInterface $channelProvider,
        AdjustmentProviderInterface $adjustmentProvider
    ) {
        $this->channelProvider = $channelProvider;
        $this->adjustmentProvider = $adjustmentProvider;
    }

    public function modify(OrderInterface $cart, ShippingMethodInterface $shippingMethod): void
    {
        Assert::lessThanEq($cart->getAdjustments(AdjustmentInterface::SHIPPING_ADJUSTMENT)->count(), 1, sprintf('More than one shipping adjustment is applied to the cart. Only one shipment is currently supported.'));

        $adjustment = $cart->getAdjustments(AdjustmentInterface::SHIPPING_ADJUSTMENT)->first();

        if (null === $adjustment) {
            $adjustment = $this->adjustmentProvider->provide($shippingMethod);
            $cart->addAdjustment($adjustment);
        }

        $adjustment->setType(AdjustmentInterface::SHIPPING_ADJUSTMENT);
        $adjustment->setLabel($shippingMethod->getName());

        $channelCode = $this->channelProvider->provide()->getCode();
        $configuration = $shippingMethod->getConfiguration();

        $adjustment->setAmount((int) $configuration[$channelCode]['amount']);
    }
}
