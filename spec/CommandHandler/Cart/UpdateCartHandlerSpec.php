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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\UpdateCartHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier\OrderModifierInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\OrderItem\OrderItemProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;

final class UpdateCartHandlerSpec extends ObjectBehavior
{
    function let(
        OrderRepositoryInterface $cartRepository,
        OrderItemProviderInterface $orderItemProvider,
        OrderModifierInterface $orderModifier
    ): void {
        $this->beConstructedWith($cartRepository, $orderItemProvider, $orderModifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateCartHandler::class);
    }

    function it_updates_cart(
        OrderInterface $cart,
        OrderRepositoryInterface $cartRepository,
        OrderItemProviderInterface $orderItemProvider,
        OrderItemInterface $cartItem,
        ProductInterface $product,
        OrderModifierInterface $orderModifier,
        ChannelInterface $channel
    ): void {
        $cartItemRequestModel = new CartItem();
        $cartItemRequestModel->qty = 2;

        $updateCart = new UpdateCart('123', 'cart-id', $cartItemRequestModel);
        $updateCart->setOrderItemUuid('uuid');

        $cartRepository->findOneBy(Argument::any())->willReturn($cart);
        $orderItemProvider->provide(Argument::any())->willReturn($cartItem);

        $cartItem->getProduct()->willReturn($product);

        $cart->getChannel()->willReturn($channel);
        $product->getChannels()->willReturn(new ArrayCollection([$channel->getWrappedObject()]));

        $orderModifier->modify($cart, $cartItem, 2, 'uuid')->shouldBeCalled();

        $this->__invoke($updateCart);
    }
}
