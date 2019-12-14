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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren\Child;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantsToConfigurableChildrenTransformer implements ProductVariantsToConfigurableChildrenTransformerInterface
{
    /** @var ProductVariantPricesTransformerInterface */
    private $productVariantPricesTransformer;

    public function __construct(ProductVariantPricesTransformerInterface $productVariantPricesTransformer)
    {
        $this->productVariantPricesTransformer = $productVariantPricesTransformer;
    }

    /** @param Collection|ProductVariantInterface[] $syliusProductVariants */
    public function transform(Collection $syliusProductVariants): ConfigurableChildren
    {
        $configurableChildren = [];

        foreach ($syliusProductVariants as $productVariant) {
            $configurableChildren[] = new Child(
                $this->productVariantPricesTransformer->transform($productVariant),
                $productVariant->getName(),
                $productVariant->getCode()
            );
        }

        return new ConfigurableChildren($configurableChildren);
    }
}
