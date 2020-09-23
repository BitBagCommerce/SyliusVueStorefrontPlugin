<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Details;
use Sylius\Component\Core\Model\ProductInterface;

final class ProductDetailsTransformer implements ProductDetailsTransformerInterface
{
    public function transform(ProductInterface $product): Details
    {
        $productVariantsCount = $product->getVariants()->count();

        $firstVariant = $product->getVariants()->first();

        return new Details(
            $product->getId(),
            null,
            null,
            $productVariantsCount > 1 ? 'configurable' : 'simple',
            $productVariantsCount === 1 ? $firstVariant->getCode() : $product->getCode(),
            $product->getSlug(),
            $product->getName(),
            null,
            null,
            $product->getCreatedAt(),
            $product->getUpdatedAt(),
            $product->getImages()->first() ? $product->getImages()->first()->getPath(): null,
            ($firstVariant->getOnHand() - $firstVariant->getOnHold()) > 0,
            null,
            $firstVariant->getTaxCategory() !== null ? $firstVariant->getTaxCategory()->getId() : null,
            $firstVariant->getTaxCategory() !== null ? $firstVariant->getTaxCategory()->getName() : null,
            $product->getDescription(),
            $product->getShortDescription(),
            1,//hasOptions
            1,//requiredOptions
            [],//productLinks
            [],//colorOptions,
            [],//sizeOptions
            $productVariantsCount === 1 ? $firstVariant->getCode() : $product->getCode()
        );
    }
}
