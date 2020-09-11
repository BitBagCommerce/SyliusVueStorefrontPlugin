<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Repository;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem\ConfigurableItemOption;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductVariantRepository implements ProductVariantRepositoryInterface
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** @param ConfigurableItemOption[] $configurableItemOptions */
    public function getVariantForOptionValuesBySku(string $sku, array $configurableItemOptions): ?ProductVariantInterface
    {
        $product = $this->productRepository->findOneByCode($sku);

        /** @var ProductVariantInterface $productVariant */
        foreach ($product->getVariants() as $productVariant) {
            $productVariantOptionValues = $productVariant->getOptionValues()->map(
                static function (ProductOptionValueInterface $productOptionValue) {
                    return [
                        'option_value' => $productOptionValue->getId(),
                        'option_id' => (string) $productOptionValue->getOption()->getId(),
                    ];
                })
            ;

            if ($this->areArraysEqual(
                $this->convertConfigurableItemOptionsToArray($configurableItemOptions),
                $productVariantOptionValues->toArray()
            )) {
                return $productVariant;
            }
        }

        return null;
    }

    private function convertConfigurableItemOptionsToArray(array $configurableItemOptions): array
    {
        $itemOptions = [];

        /** @var ConfigurableItemOption $configurableItemOption */
        foreach ($configurableItemOptions as $configurableItemOption) {
            $itemOptions[] = [
                'option_value' => $configurableItemOption->option_value,
                'option_id' => $configurableItemOption->option_id,
            ];
        }

        return $itemOptions;
    }

    private function areArraysEqual(array $first, array $second): bool
    {
        if (count($first) !== count($second)) {
            return false;
        }
        foreach ($second as $key => $value) {
            if (!in_array($value, $first, false)) {
                return false;
            }

            if (count(array_keys($first, $value, false)) !== count(array_keys($second, $value, false))) {
                return false;
            }
        }

        return true;
    }
}
