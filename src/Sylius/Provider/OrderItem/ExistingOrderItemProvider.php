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
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class ExistingOrderItemProvider implements OrderItemProviderInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    public function __construct(OrderRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function provide(UpdateCart $updateCart): OrderItemInterface
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy([
            'tokenValue' => $updateCart->cartId(),
            'state' => OrderInterface::STATE_CART,
        ]);

        /** @var OrderItemInterface $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            if ($updateCart->cartItem()->getItemId() === $cartItem->getId()) {
                return $cartItem;
            }
        }

        return null;
    }
}
