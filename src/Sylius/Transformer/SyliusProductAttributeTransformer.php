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
use Sylius\Component\Product\Model\ProductAttributeInterface;

final class SyliusProductAttributeTransformer implements SyliusProductAttributeTransformerInterface
{
    public function transform(ProductAttributeInterface $syliusProductAttribute): Attribute
    {
        return new Attribute(
            $syliusProductAttribute->getId(),
            $syliusProductAttribute->getId(),
            $syliusProductAttribute->getId(),
            $syliusProductAttribute->getCode(),
            $syliusProductAttribute->getId(),
            [],
            false,
            false,
            false,
            false,
            false,
            'select',
            $syliusProductAttribute->getName()
        );
    }
}
