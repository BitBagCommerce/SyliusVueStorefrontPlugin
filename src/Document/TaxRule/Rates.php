<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\TaxRule;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\TaxRate\Rate;

final class Rates
{
    private const TAX_RATES = 'rates';

    private const TAX_RATES_IDS = 'tax_rates_ids';

    /** @var Rate[] */
    private $taxRates;

    /** @var int[] */
    private $ids;

    public function __construct(array $taxRates, array $ids)
    {
        $this->taxRates = $taxRates;
        $this->ids = $ids;
    }

    public function toArray(): array
    {
        return [
            self::TAX_RATES => $this->taxRates,
            self::TAX_RATES_IDS => $this->ids,
        ];
    }
}
