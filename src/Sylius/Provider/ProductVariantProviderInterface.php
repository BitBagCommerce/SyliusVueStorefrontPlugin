<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\ProductVariantInterface;

interface ProductVariantProviderInterface
{
    public function provideForOptionValuesBySku(string $sku, array $configurableItemOptions): ProductVariantInterface;
}
