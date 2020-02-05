<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Stock;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\InventoryToStockTransformer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class InventoryToStockTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(InventoryToStockTransformer::class);
    }

    function it_transforms_inventory_to_stock(ProductInterface $product, ProductVariantInterface $productVariant): void
    {
        $productVariant->getProduct()->willReturn($product);
        $product->getId()->willReturn(1);
        $productVariant->getId()->willReturn(1);
        $productVariant->getOnHand()->willReturn(2);
        $productVariant->getOnHold()->willReturn(1);

        $this->transform($productVariant)->shouldReturnAnInstanceOf(Stock::class);
    }
}
