<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule;
use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer\TaxCategoryToVueStorefrontDocumentTransformer;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategoryToTaxRuleTransformerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;

final class TaxCategoryToVueStorefrontDocumentTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxCategoryToVueStorefrontDocumentTransformer::class);
    }

    function let(SyliusTaxCategoryToTaxRuleTransformerInterface $syliusTaxCategoryTransformer): void
    {
        $this->beConstructedWith($syliusTaxCategoryTransformer);
    }

    function it_transforms_sylius_tax_category_to_vue_storefront_tax_rule(
        SyliusTaxCategoryToTaxRuleTransformerInterface $syliusTaxCategoryTransformer,
        TaxCategoryInterface $taxCategory
    ): void {
        $taxRule = new TaxRule(
            1,
            1,
            'example-code',
            1,
            0,
            [],
            [],
            [],
            true,
            new Rates([], [])
        );

        $syliusTaxCategoryTransformer->transform($taxCategory)->willReturn($taxRule);

        $this->transform($taxCategory, []);
    }
}
