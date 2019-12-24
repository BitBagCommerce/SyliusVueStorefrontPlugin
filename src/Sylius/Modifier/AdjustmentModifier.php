<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\AdjustmentProviderInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final class AdjustmentModifier implements AdjustmentModifierInterface
{
    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var AdjustmentProviderInterface */
    private $adjustmentProvider;

    /** @var ObjectManager */
    private $entityManager;

    public function __construct(
        ChannelContextInterface $channelContext,
        AdjustmentProviderInterface $adjustmentProvider,
        ObjectManager $entityManager
    ) {
        $this->channelContext = $channelContext;
        $this->adjustmentProvider = $adjustmentProvider;
        $this->entityManager = $entityManager;
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

        $channelCode = $this->channelContext->getChannel()->getCode();
        $configuration = $shippingMethod->getConfiguration();

        $adjustment->setAmount((int) $configuration[$channelCode]['amount']);

        $this->entityManager->persist($adjustment);
        $this->entityManager->flush();
    }
}
