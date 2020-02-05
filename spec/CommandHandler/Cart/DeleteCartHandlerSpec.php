<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\DeleteCart;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\DeleteCartHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Order\Repository\OrderItemRepositoryInterface;

final class DeleteCartHandlerSpec extends ObjectBehavior
{
    function let(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderProcessorInterface $orderProcessor
    ): void {
        $this->beConstructedWith(
            $orderRepository,
            $orderItemRepository,
            $orderProcessor
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(DeleteCartHandler::class);
    }

    function it_deletes_cart_item_from_cart(
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        OrderInterface $order,
        OrderItemInterface $orderItem,
        OrderProcessorInterface $orderProcessor
    ): void {
        $cartItem = new CartItem();
        $cartItem->setItemId(123);

        $deleteCart = new DeleteCart($cartItem, 'cart-id');

        $orderRepository->findOneBy(['tokenValue' => 'cart-id', 'state' => 'cart'])->willReturn($order);

        $orderItemRepository->findOneBy(['id' => 123])->willReturn($orderItem);

        $order->removeItem($orderItem)->shouldBeCalled();

        $orderItemRepository->remove($orderItem)->shouldBeCalled();

        $orderProcessor->process($order)->shouldBeCalled();

        $this->__invoke($deleteCart);
    }
}
