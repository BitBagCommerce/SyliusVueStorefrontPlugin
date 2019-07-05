<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Stock;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class InventoryToStockTransformer implements InventoryToStockTransformerInterface
{
    public function transform(ProductVariantInterface $productVariant): Stock
    {
        return new Stock(
            1,
            $productVariant->getOnHand(),
            $productVariant->getId(),
            $productVariant->getId()
//            false,
//            $productVariant->getOnHand() > 0
        );
    }
}
