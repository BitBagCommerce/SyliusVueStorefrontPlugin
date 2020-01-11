<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ProductVariant;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class AlreadyInCartProductVariantProvider implements ProductVariantProviderInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    public function __construct(OrderRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function provide(CommandInterface $command): ProductVariantInterface
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy(['tokenValue' => $command->cartId()]);

        /** @var OrderItemInterface $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            if ($command->cartItem()->getItemId() === $cartItem->getId()) {
                return $cartItem->getVariant();
            }
        }

        return null;
    }
}
