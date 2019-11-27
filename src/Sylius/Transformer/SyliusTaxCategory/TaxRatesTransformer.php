<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;
use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\TaxRate\Rate;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxRateInterface;

final class TaxRatesTransformer implements TaxRatesTransformerInterface
{
    /** @param Collection|TaxRateInterface[] $taxRates */
    public function transform(Collection $taxRates): Rates
    {
        $rates = [];
        $ratesIds = [];

        foreach ($taxRates as $taxRate) {
            $rates[] = new Rate(
                $taxRate->getId(),
                $taxRate->getCode(),
                (int) $taxRate->getAmountAsPercentage(),
                ('country' === $taxRate->getZone()->getType()) ? $taxRate->getZone()->getName() : null,
                5,
                5,
                false,
                null,
                null
            );

            $ratesIds[] = $taxRate->getId();
        }
        return new Rates($rates, $ratesIds);
    }
}
