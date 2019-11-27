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
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductOptionsToConfigurableOptionsTransformer implements ProductOptionsToConfigurableOptionsTransformerInterface
{
    /** @param Collection|ProductOptionInterface[] $syliusProductOptions */
    public function transform(Collection $syliusProductOptions): ConfigurableOptions
    {
        $configurableOptions = [];

        foreach ($syliusProductOptions as $syliusProductOption) {
            $configurableOptionValues = $this->processValues($syliusProductOption->getValues());

            $configurableOptions[] = new Option(
                $syliusProductOption->getId(),
                $configurableOptionValues,
                5, //product_id ,
                $syliusProductOption->getName(),
                $syliusProductOption->getPosition(),
                5, //attribute_id
                $syliusProductOption->getCode() //attribute_code
            );
        }

        return new ConfigurableOptions($configurableOptions);
    }

    private function processValues(Collection $syliusProductOptionValues): array
    {
        $configurableOptionValues = [];

        /** @var ProductOptionValueInterface $syliusProductOptionValue */
        foreach ($syliusProductOptionValues as $syliusProductOptionValue) {
            //            TODO OPTION VALUE STRING TO INT
            $configurableOptionValues[] = new OptionValue($syliusProductOptionValue->getId(), $syliusProductOptionValue->getName());
        }

        return $configurableOptionValues;
    }
}
