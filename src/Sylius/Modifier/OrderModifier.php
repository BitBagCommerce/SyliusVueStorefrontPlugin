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

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class OrderModifier implements OrderModifierInterface
{
    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var ObjectManager */
    private $orderManager;

    public function __construct(
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        OrderProcessorInterface $orderProcessor,
        ObjectManager $orderManager
    ) {
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->orderProcessor = $orderProcessor;
        $this->orderManager = $orderManager;
    }

    public function modify(
        OrderInterface $order,
        OrderItemInterface $cartItem,
        int $newQuantity,
        string $uuid
    ): void {
        $this->orderItemQuantityModifier->modify($cartItem, $newQuantity);

        $cartItem->setUuid($uuid);

        $this->orderProcessor->process($order);

        $this->orderManager->persist($order);
    }
}
