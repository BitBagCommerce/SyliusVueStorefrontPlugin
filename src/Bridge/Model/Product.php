<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Model;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Mapper\ProductMapperInterface;
use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Category;
use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Media;
use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Stock;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ProductVariantInterface as SyliusProductVariantInterface;
use Sylius\Component\Core\Model\TaxonInterface;

final class Product implements ProductInterface
{
    /** @var int */
    private $documentId;

    /** @var int */
    private $entityId;

    /** @var int */
    private $attributeSetId;

    /** @var string */
    private $type;

    /** @var string */
    private $sku;

    /** @var string */
    private $urlKey;

    /** @var string */
    private $name;

    /** @var int */
    private $price;

    /** @var int */
    private $status;

    /** @var int */
    private $visibility;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var int */
    private $weight;

    /** @var string */
    private $ean;

    /** @var string */
    private $image;

    /** @var string */
    private $availability;

    /** @var string */
    private $textStatus;

    /** @var string */
    private $taxClassId;

    /** @var string */
    private $textTaxClassId;

    /** @var string */
    private $description;

    /** @var string */
    private $shortDescription;

    /** @var Stock */
    private $stock;

    /** @var Category[] */
    private $category;

    /** @var Media[] */
    private $mediaGallery;

    /** @var int[] */
    private $categoryIds;

    /** @var int */
    private $hasOptions;

    /** @var int */
    private $requiredOptions;

    /** @var array */
    private $productLinks;

    /** @var array */
    private $colorOptions;

    /** @var array */
    private $sizeOptions;

    /** @var array */
    private $configurableOptions;

    /** @var array */
    private $configurableChildren;

    private function __construct(
        int $documentId,
        int $entityId,
        ?int $attributeSetId,
        ?string $type,
        string $sku,
        string $urlKey,
        string $name,
        int $price,
        ?int $status,
        ?int $visibility,
        string $createdAt,
        string $updatedAt,
        int $weight,
        string $ean,
        string $image,
        ?string $availability,
        ?string $textStatus,
        ?string $taxClassId,
        ?string $textTaxClassId,
        string $description,
        string $shortDescription,
        Stock $stock,
        array $category,
        array $mediaGallery,
        array $categoryIds,
        int $hasOptions,
        int $requiredOptions,
        array $productLinks,
        array $colorOptions,
        array $sizeOptions,
        array $configurableOptions,
        array $configurableChildren
    ) {
        $this->documentId = $documentId;
        $this->entityId = $entityId;
        $this->attributeSetId = $attributeSetId ?? ProductMapperInterface::DEFAULT_ATTRIBUTE_SET_ID;
        $this->type = $type ?? ProductMapperInterface::SIMPLE_TYPE;
        $this->sku = $sku;
        $this->urlKey = $urlKey;
        $this->name = $name;
        $this->price = $price;
        $this->status = $status ?? ProductMapperInterface::DEFAULT_STATUS;
        $this->visibility = $visibility ?? ProductMapperInterface::DEFAULT_VISIBILITY;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->weight = $weight;
        $this->ean = $ean;
        $this->image = $image;
        $this->availability = $availability ?? ProductMapperInterface::DEFAULT_AVAILABILITY;
        $this->textStatus = $textStatus ?? ProductMapperInterface::DEFAULT_OPTION_STATUS;
        $this->taxClassId = $taxClassId ?? ProductMapperInterface::DEFAULT_TAX_CLASS_ID;
        $this->textTaxClassId = $textTaxClassId ?? ProductMapperInterface::DEFAULT_OPTION_CLASS_ID;
        $this->description = $description;
        $this->shortDescription = $shortDescription;
        $this->stock = $stock;
        $this->category = $category;
        $this->mediaGallery = $mediaGallery;
        $this->categoryIds = $categoryIds;
        $this->hasOptions = $hasOptions;
        $this->requiredOptions = $requiredOptions;
        $this->productLinks = $productLinks;
        $this->colorOptions = $colorOptions;
        $this->sizeOptions = $sizeOptions;
        $this->configurableOptions = $configurableOptions;
        $this->configurableChildren = $configurableChildren;
    }

    public static function fromSyliusProductVariant(SyliusProductVariantInterface $productVariant, $locale = 'en_US'): self
    {
        $stock = Stock::fromSyliusProductVariant($productVariant);

        $channel = null;

        [$categories, $categoriesIds] = self::configureCategories($productVariant->getProduct()->getTaxons());
        $mediaGallery = self::configureMediaGallery($productVariant->getImages());

        return new self(
            $productVariant->getId(),
            $productVariant->getId(),
            null,
            null,
            $productVariant->getCode(),
            'url', //urlKey
            $productVariant->getTranslation($locale)->getName(),
            5,//$productVariant->getChannelPricingForChannel($channel),
            null,
            null,
            $productVariant->getCreatedAt()->format(self::DATE_FORMAT),
            $productVariant->getUpdatedAt()->format(self::DATE_FORMAT),
            $productVariant->getWeight() ?? 5,
            $productVariant->getCode(),
            'img', //image,
            null,
            null,
            null,
            null,
            $productVariant->getProduct()->getTranslation($locale)->getDescription(),
            $productVariant->getProduct()->getTranslation($locale)->getShortDescription(),
            $stock,
            $categories,
            $mediaGallery,
            $categoriesIds,
            1,//hasOptions
            1,//requiredOptions
            [],//productLinks
            [],//colorOptions,
            [],//sizeOptions
            [],//configurableOptions
            []//configurableChildren
        );
    }

    public function toElasticArray(): array
    {
        $result = [];

        $result[self::ENTITY_ID] = $this->entityId;
        $result[self::ATTRIBUTE_SET_ID] = $this->attributeSetId;
        $result[self::TYPE] = $this->type;
        $result[self::SKU] = $this->sku;
        $result[self::URL_KEY] = $this->urlKey;
        $result[self::NAME] = $this->name;
        $result[self::PRICE] = $this->price;
        $result[self::STATUS] = $this->status;
        $result[self::VISIBILITY] = $this->visibility;
        $result[self::CREATED_AT] = $this->createdAt;
        $result[self::UPDATED_AT] = $this->updatedAt;
        $result[self::WEIGHT] = $this->weight;
        $result[self::EAN] = $this->ean;
        $result[self::IMAGE] = $this->image;
        $result[self::AVAILABILITY] = $this->availability;
        $result[self::TEXT_STATUS] = $this->textStatus;
        $result[self::TAX_CLASS_ID] = $this->taxClassId;
        $result[self::TEXT_TAX_CLASS_ID] = $this->textTaxClassId;
        $result[self::DESCRIPTION] = $this->description;
        $result[self::SHORT_DESCRIPTION] = $this->shortDescription;
        $result[self::STOCK] = $this->stock;
        $result[self::CATEGORY] = $this->category;
        $result[self::MEDIA_GALLERY] = $this->mediaGallery;
        $result[self::CATEGORY_IDS] = $this->categoryIds;
        $result[self::HAS_OPTIONS] = $this->hasOptions;
        $result[self::REQUIRED_OPTIONS] = $this->requiredOptions;
        $result[self::PRODUCT_LINKS] = $this->productLinks;
        $result[self::COLOR_OPTIONS] = $this->colorOptions;
        $result[self::SIZE_OPTIONS] = $this->sizeOptions;
        $result[self::CONFIGURABLE_OPTIONS] = $this->configurableOptions;
        $result[self::CONFIGURABLE_CHILDREN] = $this->configurableChildren;

        return $result;
    }


    /** @param Collection|TaxonInterface[] $taxons */
    private static function configureCategories(Collection $taxons): array
    {
        $categories = [];
        $categoryIds = [];

        foreach ($taxons as $taxon) {
            $categories[] = json_encode(Category::fromSyliusTaxon($taxon));
            $categoryIds[] = $taxon->getId();
        }

        return [$categories, $categoryIds];
    }

    /** @param Collection|ImageInterface[] $images */
    private static function configureMediaGallery(Collection $images): array
    {
        return [];
    }
}
