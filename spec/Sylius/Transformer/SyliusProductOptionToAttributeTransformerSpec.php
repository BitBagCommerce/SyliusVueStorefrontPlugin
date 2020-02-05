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

use BitBag\SyliusVueStorefrontPlugin\Document\Attribute;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductOption\ProductOptionsValuesTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductOptionToAttributeTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class SyliusProductOptionToAttributeTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusProductOptionToAttributeTransformer::class);
    }

    function let(ProductOptionsValuesTransformerInterface $productOptionsValuesTransformer): void
    {
        $this->beConstructedWith($productOptionsValuesTransformer);
    }

    function it_transforms_sylius_product_option_to_attribute(
        ProductOptionInterface $syliusProductOption,
        ProductOptionValueInterface $syliusProductOptionValue,
        ProductOptionsValuesTransformerInterface $productOptionsValuesTransformer
    ): void {
        $syliusProductOption->getId()->willReturn(1);
        $syliusProductOption->getCode()->willReturn('code');
        $syliusProductOption->getName()->willReturn(1);
        $syliusProductOption->getValues()
            ->willReturn(new ArrayCollection([$syliusProductOptionValue->getWrappedObject()]));

        $productOptionsValuesTransformer->transform($syliusProductOptionValue)
            ->willReturn(new Attribute\Option('label', 1));

        $this->transform($syliusProductOption);
    }
}
