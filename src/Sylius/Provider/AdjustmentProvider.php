<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\AdjustmentInterface as BaseAdjustmentInterface;

final class AdjustmentProvider implements AdjustmentProviderInterface
{
    /** @var AdjustmentFactoryInterface $adjustmentFactory */
    private $adjustmentFactory;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(AdjustmentFactoryInterface $adjustmentFactory, ChannelContextInterface $channelContext)
    {
        $this->adjustmentFactory = $adjustmentFactory;
        $this->channelContext = $channelContext;
    }

    public function provide(ShippingMethodInterface $shippingMethod): BaseAdjustmentInterface
    {
        /** @var BaseAdjustmentInterface $adjustment */
        $adjustment = $this->adjustmentFactory->createNew();
        $adjustment->setType(AdjustmentInterface::SHIPPING_ADJUSTMENT);
        $adjustment->setLabel($shippingMethod->getName());

        $channelCode = $this->channelContext->getChannel()->getCode();
        //$configuration = json_decode(json_encode($shippingMethod->getConfiguration()), false);
        $configuration = $shippingMethod->getConfiguration();

        //$adjustment->setAmount($configuration->$channelCode->amount);
        $adjustment->setAmount((int) $configuration[$channelCode]['amount']);

        return $adjustment;
    }
}
