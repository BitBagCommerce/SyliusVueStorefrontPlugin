<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Translator;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductTranslator implements ProductTranslatorInterface
{
    public function translate(ProductInterface $product): iterable
    {
        foreach ($product->getVariants() as $productVariant) {
            yield $this->serializeProductVariant($productVariant);
        }
    }

    private function serializeProductVariant(ProductVariantInterface $productVariant): array
    {
        return [

        ];
    }
}
