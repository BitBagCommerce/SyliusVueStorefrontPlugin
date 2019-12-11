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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductOptionsToConfigurableOptionsTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class ProductOptionsToConfigurableOptionsTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductOptionsToConfigurableOptionsTransformer::class);
    }

    function it_transforms(ProductOptionInterface $syliusProductOption, ProductOptionValueInterface $productOptionValue): void
    {
        $productOptionValue->getId()->willReturn(1);
        $productOptionValue->getName()->willReturn('name');

        $syliusProductOption->getValues()->willReturn(
            new ArrayCollection(
                [
                    $productOptionValue->getWrappedObject(),
                ]
            )
        );

        $syliusProductOption->getId()->willReturn(1);
        $syliusProductOption->getName()->willReturn('name');
        $syliusProductOption->getPosition()->willReturn(1);
        $syliusProductOption->getCode()->willReturn('code');

        $this->transform(
            new ArrayCollection(
                [
                    $syliusProductOption->getWrappedObject(),
                ]
            )
        )->shouldReturnAnInstanceOf(ConfigurableOptions::class);
    }
}
