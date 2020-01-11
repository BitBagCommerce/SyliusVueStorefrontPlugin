<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Category;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\Details;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\Price;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\Stock;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\StockItem;

final class Product implements ProductInterface
{
    /** @var int */
    private $documentId;

    /** @var Details */
    private $details;

    /** @var Stock */
    private $stock;

    /** @var Category */
    private $category;

    /** @var MediaGallery */
    private $mediaGallery;

    /** @var ConfigurableChildren */
    private $configurableChildren;

    /** @var ConfigurableOptions */
    private $configurableOptions;

    /** @var ProductLinks */
    private $productLinks;

    /** @var Price */
    private $price;

    /** @var StockItem */
    private $stockItem;

    public function __construct(
        int $documentId,
        Details $details,
        Stock $stock,
        Category $category,
        MediaGallery $mediaGallery,
        ?ConfigurableChildren $configurableChildren,
        ?ConfigurableOptions $configurableOptions,
        ProductLinks $productLinks,
        Price $price,
        StockItem $stockItem
    ) {
        $this->documentId = $documentId;
        $this->stock = $stock;
        $this->category = $category;
        $this->mediaGallery = $mediaGallery;
        $this->details = $details;
        $this->configurableChildren = $configurableChildren;
        $this->configurableOptions = $configurableOptions;
        $this->productLinks = $productLinks;
        $this->price = $price;
        $this->stockItem = $stockItem;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function toElasticArray(): array
    {
        return \array_merge(
            [
                self::STOCK => $this->stock,
                self::STOCK_ITEM => $this->stockItem,
            ],
            $this->details->toArray(),
            $this->category->toArray(),
            $this->mediaGallery->toArray(),
            $this->details->isConfigurableProduct() ? $this->configurableChildren->toArray() : [],
            $this->details->isConfigurableProduct() ? $this->configurableOptions->toArray() : [],
            $this->productLinks->toArray(),
            $this->price->toArray()
        );
    }
}
