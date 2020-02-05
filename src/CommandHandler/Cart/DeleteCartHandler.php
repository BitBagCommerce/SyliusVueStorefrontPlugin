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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItem;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Order\Repository\OrderItemRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteCartHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderProcessorInterface $orderProcessor
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->orderProcessor = $orderProcessor;
    }

    public function __invoke(DeleteCart $deleteCart): void
    {
        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneBy([
            'tokenValue' => $deleteCart->cartId(),
            'state' => OrderInterface::STATE_CART,
        ]);

        if (!$order) {
            return;
        }

        /** @var OrderItem|null $orderItem */
        $orderItem = $this->orderItemRepository->findOneBy(['id' => $deleteCart->cartItem()->getItemId()]);

        if ($orderItem) {
            $order->removeItem($orderItem);
            $this->orderItemRepository->remove($orderItem);
        }

        $this->orderProcessor->process($order);
    }
}
