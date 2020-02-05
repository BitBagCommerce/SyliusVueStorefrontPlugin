<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule;
use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory\TaxRatesTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategoryToTaxRuleTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;

final class SyliusTaxCategoryToTaxRuleTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusTaxCategoryToTaxRuleTransformer::class);
    }

    function let(TaxRatesTransformerInterface $taxRatesTransformer): void
    {
        $this->beConstructedWith($taxRatesTransformer);
    }

    function it_transforms_sylius_tax_category_to_tax_rule(
        TaxRatesTransformerInterface $taxRatesTransformer,
        TaxCategoryInterface $taxCategory
    ): void {
        $taxCategory->getRates()->shouldBeCalled();
        $taxCategory->getId()->willReturn(1);
        $taxCategory->getCode()->willReturn('code');

        $taxRatesTransformer->transform(Argument::any())->willReturn(new Rates([], []));

        $this->transform($taxCategory)->shouldReturnAnInstanceOf(TaxRule::class);
    }
}
