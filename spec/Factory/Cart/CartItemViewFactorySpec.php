<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderItemInterface as SyliusOrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Model\OrderInterface;

final class CartItemViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CartItemViewFactory::class);
    }

    function it_creates_one_cart_item_view(
        SyliusOrderItemInterface $syliusOrderItem,
        ProductVariantInterface $productVariant,
        OrderInterface $order
    ): void {
        $syliusOrderItem->getId()->shouldBeCalled();
        $syliusOrderItem->getVariant()->willReturn($productVariant);
        $syliusOrderItem->getQuantity()->shouldBeCalled();
        $syliusOrderItem->getVariantName()->shouldBeCalled();
        $syliusOrderItem->getUnitPrice()->shouldBeCalled();
        $syliusOrderItem->getOrder()->willReturn($order);
        $this->create($syliusOrderItem)->shouldReturnAnInstanceOf(CartItemView::class);
    }
}
