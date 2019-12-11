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
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer\ProductAttributeToVueStorefrontDocumentTransformer;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductAttributeTransformerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Product\Model\ProductAttributeInterface;

final class ProductAttributeToVueStorefrontDocumentTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductAttributeToVueStorefrontDocumentTransformer::class);
    }

    function let(SyliusProductAttributeTransformerInterface $syliusProductAttributeTransformer): void
    {
        $this->beConstructedWith($syliusProductAttributeTransformer);
    }

    function it_transforms_sylius_product_attribute_to_vue_storefront_attribute(
        SyliusProductAttributeTransformerInterface $syliusProductAttributeTransformer,
        ProductAttributeInterface $syliusProductAttribute
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

        $syliusProductAttributeTransformer->transform($syliusProductAttribute)->willReturn($attribute);

        $this->transform($syliusProductAttribute, []);
    }
}
