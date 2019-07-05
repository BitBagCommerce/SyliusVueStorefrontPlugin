<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory\TaxRatesTransformerInterface;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;

final class SyliusTaxCategoryToTaxRuleTransformer implements SyliusTaxCategoryToTaxRuleTransformerInterface
{
    /** @var TaxRatesTransformerInterface */
    private $taxRatesTransformer;

    public function __construct(TaxRatesTransformerInterface $taxRatesTransformer)
    {
        $this->taxRatesTransformer = $taxRatesTransformer;
    }

    public function transform(TaxCategoryInterface $taxCategory): TaxRule
    {
        $rates = $this->taxRatesTransformer->transform($taxCategory->getRates());

        return new TaxRule(
            $taxCategory->getId(),
            $taxCategory->getId(),
            $taxCategory->getCode(),
            0,
            0,
            [],
            [],
            [],
            false,
            $rates,
            5
        );
    }
}
