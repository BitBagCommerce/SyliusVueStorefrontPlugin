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
