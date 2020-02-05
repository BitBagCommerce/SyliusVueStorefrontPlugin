<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\Price;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantOptionValuesToCustomAttributesTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantPricesTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantsToConfigurableChildrenTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductVariantsToConfigurableChildrenTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductVariantsToConfigurableChildrenTransformer::class);
    }

    function let(
        ProductVariantPricesTransformerInterface $productVariantPricesTransformer,
        ProductVariantOptionValuesToCustomAttributesTransformerInterface $productVariantOptionValuesTransformer
    ): void {
        $this->beConstructedWith($productVariantPricesTransformer, $productVariantOptionValuesTransformer);
    }

    function it_transforms_product_variants_to_configurable_children(
        ProductVariantInterface $productVariant,
        ProductVariantPricesTransformerInterface $productVariantPricesTransformer,
        ProductVariantOptionValuesToCustomAttributesTransformerInterface $productVariantOptionValuesTransformer,
        ProductOptionValueInterface $optionValue
    ): void {
        $productVariantPricesTransformer->transform($productVariant)->willReturn(new Price());

        $productVariant->getName()->willReturn('name');
        $productVariant->getCode()->willReturn('code');

        $productVariantOptionValuesTransformer->transform($productVariant)->willReturn([$optionValue]);

        $this->transform(new ArrayCollection([$productVariant->getWrappedObject()]))
            ->shouldReturnAnInstanceOf(ConfigurableChildren::class);
    }
}
