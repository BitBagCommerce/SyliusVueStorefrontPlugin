<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\DeleteCoupon;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\DeleteCouponHandler;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class DeleteCouponHandlerSpec extends ObjectBehavior
{
    function let(
        OrderRepositoryInterface $orderRepository,
        OrderProcessorInterface $orderProcessor
    ): void {
        $this->beConstructedWith($orderRepository, $orderProcessor);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(DeleteCouponHandler::class);
    }

    function it_deletes_coupon(
        OrderRepositoryInterface $orderRepository,
        OrderProcessorInterface $orderProcessor,
        OrderInterface $cart
    ): void {
        $deleteCoupon = new DeleteCoupon('token', 'cart-id');

        $orderRepository->findOneBy(['tokenValue' => 'cart-id'])->willReturn($cart);

        $cart->setPromotionCoupon(null)->shouldBeCalled();

        $orderProcessor->process($cart)->shouldBeCalled();

        $this->__invoke($deleteCoupon);
    }
}
