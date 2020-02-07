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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface as SyliusOrderItemInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CartItemViewFactorySpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(CartItemView::class);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CartItemViewFactory::class);
    }

    function it_creates_one_cart_item_view(
        SyliusOrderItemInterface $syliusOrderItem,
        ProductVariantInterface $productVariant,
        OrderInterface $order,
        ProductInterface $product,
        ArrayCollection $collection
    ): void {
        $product->getVariants()->willReturn($collection);

        $productVariant->getProduct()->willReturn($product);
        $productVariant->getOptionValues()->willReturn($collection);
        $productVariant->getCode()->willReturn('code');

        $syliusOrderItem->getId()->shouldBeCalled();
        $syliusOrderItem->getVariant()->willReturn($productVariant);
        $syliusOrderItem->getQuantity()->shouldBeCalledTimes(2);
        $syliusOrderItem->getProductName()->shouldBeCalled();
        $syliusOrderItem->getFullDiscountedUnitPrice()->shouldBeCalledTimes(2);
        $syliusOrderItem->getTotal()->shouldBeCalled();
        $syliusOrderItem->getOrder()->willReturn($order);

        $this->create($syliusOrderItem)->shouldReturnAnInstanceOf(CartItemView::class);
    }
}
