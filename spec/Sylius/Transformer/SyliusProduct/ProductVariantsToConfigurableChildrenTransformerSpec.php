<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantsToConfigurableChildrenTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantsToConfigurableChildrenTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductVariantsToConfigurableChildrenTransformer::class);
    }

    function it_transforms(ProductVariantInterface $productVariant): void
    {
        $productVariant->getName()->willReturn('name');
        $productVariant->getCode()->willReturn('code');

        $this->transform(
            new ArrayCollection(
                [
                    $productVariant->getWrappedObject(),
                ]
            )
        )->shouldReturnAnInstanceOf(ConfigurableChildren::class);
    }
}
