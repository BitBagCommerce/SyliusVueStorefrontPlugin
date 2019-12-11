<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Product;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ImagesToMediaGalleryTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\InventoryToStockTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductAssociationsToLinksTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductDetailsTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductOptionsToConfigurableOptionsTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantsToConfigurableChildrenTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\TaxonsToCategoriesTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductImage;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariant;

final class SyliusProductTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusProductTransformer::class);
    }

    function let(
        ProductDetailsTransformerInterface $productDetailsTransformer,
        InventoryToStockTransformerInterface $inventoryTransformer,
        ImagesToMediaGalleryTransformerInterface $imagesTransformer,
        TaxonsToCategoriesTransformerInterface $taxonsTransformer,
        ProductVariantsToConfigurableChildrenTransformerInterface $productVariantsTransformer,
        ProductOptionsToConfigurableOptionsTransformerInterface $productOptionsTransformer,
        ProductAssociationsToLinksTransformerInterface $productAssociationsTransformer
    ): void {
        $this->beConstructedWith(
            $productDetailsTransformer,
            $inventoryTransformer,
            $imagesTransformer,
            $taxonsTransformer,
            $productVariantsTransformer,
            $productOptionsTransformer,
            $productAssociationsTransformer
        );
    }

    function it_transforms(
        ProductInterface $syliusProduct,
        ProductDetailsTransformerInterface $productDetailsTransformer,
        InventoryToStockTransformerInterface $inventoryTransformer,
        ImagesToMediaGalleryTransformerInterface $imagesTransformer,
        TaxonsToCategoriesTransformerInterface $taxonsTransformer,
        ProductVariantsToConfigurableChildrenTransformerInterface $productVariantsTransformer,
        ProductOptionsToConfigurableOptionsTransformerInterface $productOptionsTransformer,
        ProductAssociationsToLinksTransformerInterface $productAssociationsTransformer
    ): void {
        $syliusProduct->getVariants()->willReturn(
            new ArrayCollection(
                [
                    new ProductVariant(),
                    new ProductVariant()
                ]
            )
        );
        $syliusProduct->getImages()->shouldBeCalled();
        $syliusProduct->getTaxons()->shouldBeCalled();
        $syliusProduct->getOptions()->shouldBeCalled();
        $syliusProduct->getAssociations()->shouldBeCalled();

        $productDetailsTransformer->transform(Argument::any())->willReturn(
            new Product\Details(
                1,
                1,
                1,
                'type',
                'sku',
                'url-key',
                'name',
                100.0,
                1,
                1,
                new \DateTime('yesterday'),
                new \DateTime('yesterday'),
                10,
                'ean',
                'image',
                true,
                'status',
                1,
                'tax',
                'description',
                'desc',
                1,
                1,
                [],
                [],
                [],
                true
            )
        );

        $inventoryTransformer->transform(Argument::any())->willReturn(
            new Product\Stock(
                1,
                1,
                1,
                1
            )
        );

        $imagesTransformer->transform(Argument::any())->willReturn(
            new Product\MediaGallery(
                [
                    new ProductImage(),
                    new ProductImage()
                ]
            )
        );

        $taxonsTransformer->transform(Argument::any())->willReturn(new Product\Category([], []));

        $productVariantsTransformer->transform(Argument::any())->willReturn(
            new Product\ConfigurableChildren(
                [
                    new ProductVariant(),
                    new ProductVariant()
                ]
            )
        );

        $productOptionsTransformer->transform(Argument::any())->willReturn(new Product\ConfigurableOptions([]));

        $productAssociationsTransformer->transform(Argument::any())->willReturn(new Product\ProductLinks([]));

        $syliusProduct->getId()->willReturn(1);

        $this->transform($syliusProduct)->shouldReturnAnInstanceOf(Product::class);
    }
}
