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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Inventory\Checker\AvailabilityCheckerInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Webmozart\Assert\Assert;

final class OrderModifier implements OrderModifierInterface
{
    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var ObjectManager */
    private $orderManager;

    /** @var AvailabilityCheckerInterface */
    private $availabilityChecker;

    public function __construct(
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        OrderProcessorInterface $orderProcessor,
        ObjectManager $orderManager,
        AvailabilityCheckerInterface $availabilityChecker
    ) {
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->orderProcessor = $orderProcessor;
        $this->orderManager = $orderManager;
        $this->availabilityChecker = $availabilityChecker;
    }

    public function modify(
        OrderInterface $order,
        OrderItemInterface $cartItem,
        int $newQuantity,
        string $uuid
    ): void {
        Assert::true(
            $this->availabilityChecker->isStockSufficient($cartItem->getVariant(), $newQuantity),
            sprintf('We don\'t have as many "%s" as you requested.', $cartItem->getProductName())
        );

        $this->orderItemQuantityModifier->modify($cartItem, $newQuantity);

        $cartItem->setUuid($uuid);

        $this->orderProcessor->process($order);

        $this->orderManager->persist($order);
    }
}
