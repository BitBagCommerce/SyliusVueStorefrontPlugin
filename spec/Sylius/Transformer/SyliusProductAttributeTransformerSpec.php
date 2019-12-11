<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Attribute;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductAttributeTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Product\Model\ProductAttributeInterface;

final class SyliusProductAttributeTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusProductAttributeTransformer::class);
    }

    function it_transforms(ProductAttributeInterface $syliusProductAttribute): void
    {
        $syliusProductAttribute->getId()->willReturn(1);
        $syliusProductAttribute->getCode()->willReturn('code');
        $syliusProductAttribute->getName()->willReturn(1);

        $this->transform($syliusProductAttribute)->shouldReturnAnInstanceOf(Attribute::class);
    }
}
