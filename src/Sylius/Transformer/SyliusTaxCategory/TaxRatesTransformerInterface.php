<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;
use Doctrine\Common\Collections\Collection;

interface TaxRatesTransformerInterface
{
    public function transform(Collection $taxRates): Rates;
}
