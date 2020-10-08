<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\AdjustmentInterface as BaseAdjustmentInterface;

final class AdjustmentProvider implements AdjustmentProviderInterface
{
    /** @var AdjustmentFactoryInterface */
    private $adjustmentFactory;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    public function __construct(AdjustmentFactoryInterface $adjustmentFactory, ChannelProviderInterface $channelProvider)
    {
        $this->adjustmentFactory = $adjustmentFactory;
        $this->channelProvider = $channelProvider;
    }

    public function provide(ShippingMethodInterface $shippingMethod): BaseAdjustmentInterface
    {
        /** @var BaseAdjustmentInterface $adjustment */
        $adjustment = $this->adjustmentFactory->createNew();
        $adjustment->setType(AdjustmentInterface::SHIPPING_ADJUSTMENT);
        $adjustment->setLabel($shippingMethod->getName());

        $channelCode = $this->channelProvider->provide()->getCode();
        $configuration = $shippingMethod->getConfiguration();

        $adjustment->setAmount((int) $configuration[$channelCode]['amount']);

        return $adjustment;
    }
}
