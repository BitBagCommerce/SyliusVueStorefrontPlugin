<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\OrderItem;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface;

final class CompositeOrderItemProvider implements OrderItemProviderInterface
{
    /** @var OrderItemProviderInterface */
    private $existingOrderItemProvider;

    /** @var OrderItemProviderInterface */
    private $newOrderItemProvider;

    public function __construct(
        OrderItemProviderInterface $existingOrderItemProvider,
        OrderItemProviderInterface $newOrderItemProvider
    ) {
        $this->existingOrderItemProvider = $existingOrderItemProvider;
        $this->newOrderItemProvider = $newOrderItemProvider;
    }

    public function provide(UpdateCart $updateCart): OrderItemInterface
    {
        if ($updateCart->cartItem()->getItemId()) {
            return $this->existingOrderItemProvider->provide($updateCart);
        }

        return $this->newOrderItemProvider->provide($updateCart);
    }
}
