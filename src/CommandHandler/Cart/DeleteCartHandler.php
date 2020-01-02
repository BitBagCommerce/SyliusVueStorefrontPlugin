<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\DeleteCart;
use Sylius\Component\Order\Repository\OrderItemRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteCartHandler implements MessageHandlerInterface
{
    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    public function __construct(OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function __invoke(DeleteCart $deleteCart): void
    {
        $orderItemToRemove = $this->orderItemRepository->findOneBy(['id' => $deleteCart->cartItem()->getItemId()]);
        if ($orderItemToRemove) {
            $this->orderItemRepository->remove($orderItemToRemove);
        }
    }
}
