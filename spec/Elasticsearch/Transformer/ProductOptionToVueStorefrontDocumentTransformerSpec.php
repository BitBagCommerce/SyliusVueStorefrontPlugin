<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Attribute;
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer\ProductOptionToVueStorefrontDocumentTransformer;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductOptionToAttributeTransformerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Product\Model\ProductOptionInterface;

final class ProductOptionToVueStorefrontDocumentTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductOptionToVueStorefrontDocumentTransformer::class);
    }

    function let(SyliusProductOptionToAttributeTransformerInterface $syliusProductOptionToAttributeTransformer): void
    {
        $this->beConstructedWith($syliusProductOptionToAttributeTransformer);
    }

    function it_transforms_sylius_product_option_to_vue_storefront_attribute(
        SyliusProductOptionToAttributeTransformerInterface $syliusProductOptionToAttributeTransformer,
        ProductOptionInterface $syliusProductOption
    ): void {
        $attribute = new Attribute(
            1,
            1,
            1,
            'example-code',
            0,
            [],
            true,
            true,
            true,
            true,
            true,
            'example-input',
            'example-label'
        );

        $syliusProductOptionToAttributeTransformer->transform($syliusProductOption)->willReturn($attribute);

        $this->transform($syliusProductOption, []);
    }
}
