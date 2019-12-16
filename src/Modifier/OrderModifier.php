<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Modifier;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class OrderModifier implements OrderModifierInterface
{
    /** @var CartItemFactoryInterface */
    private $cartItemFactory;

    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var ObjectManager */
    private $orderManager;

    public function __construct(
        CartItemFactoryInterface $cartItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        OrderProcessorInterface $orderProcessor,
        ObjectManager $orderManager
    ) {
        $this->cartItemFactory = $cartItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->orderProcessor = $orderProcessor;
        $this->orderManager = $orderManager;
    }

    public function modify(OrderInterface $order, ProductVariantInterface $productVariant, int $quantity, string $uuid): void
    {
        $cartItem = $this->getCartItemToModify($order, $productVariant);
        if (null !== $cartItem) {
            $this->orderItemQuantityModifier->modify($cartItem, $cartItem->getQuantity() + $quantity);
            $cartItem->setUuid($uuid);
            $this->orderProcessor->process($order);
            $this->orderManager->persist($order);

            return;
        }

        $cartItem = $this->cartItemFactory->createForCart($order);
        $cartItem->setVariant($productVariant);
        $cartItem->setUuid($uuid);
        $this->orderItemQuantityModifier->modify($cartItem, $quantity);

        $order->addItem($cartItem);

        $this->orderProcessor->process($order);

        $this->orderManager->persist($order);
    }

    private function getCartItemToModify(OrderInterface $cart, ProductVariantInterface $productVariant): ?OrderItemInterface
    {
        /** @var OrderItemInterface $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            if ($productVariant === $cartItem->getVariant()) {
                return $cartItem;
            }
        }

        return null;
    }
}
