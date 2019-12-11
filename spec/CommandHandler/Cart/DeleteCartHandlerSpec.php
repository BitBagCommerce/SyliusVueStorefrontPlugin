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
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class DeleteCartHandlerSpec extends ObjectBehavior
{
    function let(OrderRepositoryInterface $cartRepository): void
    {
        $this->beConstructedWith($cartRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(DeleteCartHandler::class);
    }

    function it_deletes_cart(
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart
    ): void {
        $deleteCart = new DeleteCart('token', 'cart-id');

        $cart->getState()->willReturn(OrderInterface::STATE_CART);

        $cartRepository->findOneBy(['tokenValue' => 'cart-id'])->willReturn($cart);

        $cartRepository->remove($cart)->shouldBeCalled();

        $this->__invoke($deleteCart);
    }
}
