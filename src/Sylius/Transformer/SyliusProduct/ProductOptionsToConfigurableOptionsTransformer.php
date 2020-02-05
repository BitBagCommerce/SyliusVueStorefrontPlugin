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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions\Option;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions\OptionValue;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductOptionsToConfigurableOptionsTransformer implements ProductOptionsToConfigurableOptionsTransformerInterface
{
    /** @param Collection|ProductOptionInterface[] $syliusProductOptions */
    public function transform(Collection $syliusProductOptions, ProductInterface $syliusProduct): ConfigurableOptions
    {
        $configurableOptions = [];

        foreach ($syliusProductOptions as $syliusProductOption) {
            $configurableOptionValues = $this->processValues($syliusProductOption->getValues());

            $configurableOptions[] = new Option(
                $syliusProductOption->getId(),
                $configurableOptionValues,
                $syliusProduct->getId(),
                $syliusProductOption->getName(),
                $syliusProductOption->getPosition(),
                $syliusProductOption->getId(),
                $syliusProductOption->getCode()
            );
        }

        return new ConfigurableOptions($configurableOptions);
    }

    private function processValues(Collection $syliusProductOptionValues): array
    {
        $configurableOptionValues = [];

        /** @var ProductOptionValueInterface $syliusProductOptionValue */
        foreach ($syliusProductOptionValues as $syliusProductOptionValue) {
            $configurableOptionValues[] = new OptionValue(
                $syliusProductOptionValue->getId(),
                $syliusProductOptionValue->getValue()
            );
        }

        return $configurableOptionValues;
    }
}
