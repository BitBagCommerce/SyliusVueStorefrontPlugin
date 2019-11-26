<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Product;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ImagesToMediaGalleryTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\InventoryToStockTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductAssociationsToLinksTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductDetailsTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductOptionsToConfigurableOptionsTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductVariantsToConfigurableChildrenTransformerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\TaxonsToCategoriesTransformerInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class SyliusProductTransformer implements SyliusProductTransformerInterface
{
    /** @var ProductDetailsTransformerInterface */
    private $productDetailsTransformer;

    /** @var InventoryToStockTransformerInterface */
    private $inventoryTransformer;

    /** @var ImagesToMediaGalleryTransformerInterface */
    private $imagesTransformer;

    /** @var TaxonsToCategoriesTransformerInterface */
    private $taxonsTransformer;

    /** @var ProductVariantsToConfigurableChildrenTransformerInterface */
    private $productVariantsTransformer;

    /** @var ProductOptionsToConfigurableOptionsTransformerInterface */
    private $productOptionsTransformer;

    /** @var ProductAssociationsToLinksTransformerInterface */
    private $productAssociationsTransformer;

    public function __construct(
        ProductDetailsTransformerInterface $productDetailsTransformer,
        InventoryToStockTransformerInterface $inventoryTransformer,
        ImagesToMediaGalleryTransformerInterface $imagesTransformer,
        TaxonsToCategoriesTransformerInterface $taxonsTransformer,
        ProductVariantsToConfigurableChildrenTransformerInterface $productVariantsTransformer,
        ProductOptionsToConfigurableOptionsTransformerInterface $productOptionsTransformer,
        ProductAssociationsToLinksTransformerInterface $productAssociationsTransformer
    ) {
        $this->productDetailsTransformer = $productDetailsTransformer;
        $this->inventoryTransformer = $inventoryTransformer;
        $this->imagesTransformer = $imagesTransformer;
        $this->taxonsTransformer = $taxonsTransformer;
        $this->productVariantsTransformer = $productVariantsTransformer;
        $this->productOptionsTransformer = $productOptionsTransformer;
        $this->productAssociationsTransformer = $productAssociationsTransformer;
    }

    public function transform(ProductInterface $syliusProduct): Product
    {
        $details = $this->productDetailsTransformer->transform($syliusProduct);
        $stock = $this->inventoryTransformer->transform($syliusProduct->getVariants()->first());
        $mediaGallery = $this->imagesTransformer->transform($syliusProduct->getImages());
        $category = $this->taxonsTransformer->transform($syliusProduct->getTaxons());
        $configurableChildren = $this->productVariantsTransformer->transform($syliusProduct->getVariants());
        $configurableOptions = $this->productOptionsTransformer->transform($syliusProduct->getOptions());
        $productLinks = $this->productAssociationsTransformer->transform($syliusProduct->getAssociations());
        $price = new Product\Price();
        $stockItem = new Product\StockItem();

        return new Product(
            $syliusProduct->getId(),
            $details,
            $stock,
            $category,
            $mediaGallery,
            $configurableChildren,
            $configurableOptions,
            $productLinks,
            $price,
            $stockItem
        );
    }
}
