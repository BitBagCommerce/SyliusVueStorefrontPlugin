<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Attribute;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductOption\ProductOptionsValuesTransformerInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;

final class SyliusProductOptionToAttributeTransformer implements SyliusProductOptionToAttributeTransformerInterface
{
    /** @var ProductOptionsValuesTransformerInterface */
    private $productOptionsValuesTransformer;

    public function __construct(ProductOptionsValuesTransformerInterface $productOptionsValuesTransformer)
    {
        $this->productOptionsValuesTransformer = $productOptionsValuesTransformer;
    }

    public function transform(ProductOptionInterface $syliusProductOption): Attribute
    {
        $attributeOptions = [];

        foreach ($syliusProductOption->getValues() as $syliusProductOptionValue) {
            $attributeOptions[] = $this->productOptionsValuesTransformer->transform($syliusProductOptionValue);
        }

        return new Attribute(
            $syliusProductOption->getId(),
            $syliusProductOption->getId(),
            $syliusProductOption->getId(),
            $syliusProductOption->getCode(),
            $syliusProductOption->getId(),
            $attributeOptions,
            false,
            true,
            false,
            true,
            true,
            'select',
            $syliusProductOption->getName()
        );
    }
}
