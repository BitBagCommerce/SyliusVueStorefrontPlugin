<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Stock;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\InventoryToStockTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class InventoryToStockTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(InventoryToStockTransformer::class);
    }

    function it_transforms(ProductVariantInterface $productVariant): void
    {
        $productVariant->getOnHand()->willReturn(1);
        $productVariant->getId()->willReturn(1);

        $this->transform($productVariant)->shouldReturnAnInstanceOf(Stock::class);
    }
}
