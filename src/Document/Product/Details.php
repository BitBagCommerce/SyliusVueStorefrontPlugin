<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product;

final class Details
{
//    private const DATE_FORMAT = 'Y-m-d H:i:s';
    private const DATE_FORMAT = 'Y-m-d';

    private const ENTITY_ID = 'id';
    private const ENTITY_TYPE_ID = 'entity_type_id';
    private const SKU = 'sku';
    private const NAME = 'name';
    private const ATTRIBUTE_SET_ID = 'attribute_set_id';
    private const PRICE = 'price';
    private const STATUS = 'status';
    private const VISIBILITY = 'visibility';
    private const TYPE = 'type_id';
    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';
    private const EXTENSION_ATTRIBUTES = 'extension_attributes';
    private const PRODUCT_LINKS = 'product_links';
    private const TIER_PRICES = 'tier_prices';
    private const CUSTOM_ATTRIBUTES = 'custom_attributes';
    private const DESCRIPTION = 'description';
    private const IMAGE = 'image';
    private const SMALL_IMAGE = 'small_image';
    private const THUMBNAIL = 'thumbnail';
    private const OPTIONS_CONTAINER = 'options_container';
    private const REQUIRED_OPTIONS = 'required_options';
    private const HAS_OPTIONS = 'has_options';
    private const URL_KEY = 'url_key';
    private const TAX_CLASS_ID = 'tax_class_id';
    private const ACTIVITY = 'activity';
    private const MATERIAL = 'material';
    private const GENDER = 'gender';
    private const CATEGORY_GEAR = 'category_gear';
    private const ERIN_RECOMMENDS = 'erin_recommends';
    private const NEW = 'new';
    private const PATTERN = 'pattern';
    private const ECO_COLLECTION = 'eco_collection';
    //https://docs.magento.com/m1/ce/user_guide/catalog/product-prices.html
    private const DISPLAY_PRICE_TYPE = 'msrp_display_actual_price_type';
    private const CLIMATE = 'climate';
    private const PERFORMANCE_FABRIC = 'performance_fabric';
    private const SALE = 'sale';
    private const CHILDREN_DATA = 'children_data';
    private const IS_RECURRING = 'is_recurring';

    // TODO DEMO APP ONLY
    private const STYLE_GENERAL = 'style_general';
    private const SLUG = 'slug';
    private const TSK = 'tsk';
    private const PARENT_SKU = 'parentSku';
    private const COLOR = 'color';
    private const SIZE = 'size';
    private const IS_CONFIGURED = 'is_configured';


    // TODO PROPERTIES BELOW APPEAR ONLY IN CORESHOP VS BRIDGE

    private const WEIGHT = 'weight';
    private const EAN = 'ean';
    private const AVAILABILITY = 'availability';
    private const TEXT_STATUS = 'option_text_status';
    private const TAX_CLASS_NAME = 'option_text_tax_class_id';
    private const SHORT_DESCRIPTION = 'short_description';
    private const COLOR_OPTIONS = 'color_options';
    private const SIZE_OPTIONS = 'size_options';


    //    INTEGRATION BOILERPLATE
    private const ACCESSORIES_SIZE = 'accessories_size';
    private const META_KEYWORD = 'meta_keyword';
    private const META_TITLE = 'meta_title';
    private const META_DESCRIPTION = 'meta_description';
    private const GIFT_MESSAGE_AVAILABLE = 'gift_message_available';
    private const GIFT_WRAPPING_AVAILABLE = 'gift_wrapping_available';
    private const NEWS_FROM_DATE = 'news_from_date';
    private const NEWS_TO_DATE = 'news_to_date';
    private const SPECIAL_FROM_DATE = 'special_from_date';
    private const SPECIAL_TO_DATE = 'special_to_date';

    private const TYPE_SIMPLE = 'simple';
    private const TYPE_CONFIGURABLE = 'configurable';

    /** https://docs.magento.com/m2/ce/user_guide/system/data-attributes-product.html */
    private const TYPES_IN_MAGENTO2 = [self::TYPE_SIMPLE, self::TYPE_CONFIGURABLE, 'grouped', 'virtual', 'bundle'];

    private const DEFAULT_ENTITY_TYPE_ID = 4;
    private const DEFAULT_ATTRIBUTE_SET_ID = 11;
    private const DEFAULT_STATUS = 1;
    private const DEFAULT_VISIBILITY = 4;
    private const DEFAULT_TYPE = self::TYPE_SIMPLE;
    private const DEFAULT_CATEGORY_ID = 2;
    private const DEFAULT_AVAILABILITY = '1';
    private const DEFAULT_OPTION_STATUS = 'Enabled';
    private const DEFAULT_TAX_CLASS_ID = 2;
    private const DEFAULT_TAX_CLASS_NAME = 'Taxable Goods';
    private const DEFAULT_CATEGORY = 'Default category';
    private const DEFAULT_MEDIA_TYPE = 'image';

//   NODEAPP MAPPING COMPARISON
    private const URL_PATH = 'url_path';
    /** @var string */
    private $urlPath;

//    END OF NODEAPP COMPARISON
    /** @var int */
    private $entityId;

    /** @var int */
    private $entityTypeId;

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

//    TODO PRICE NEEDS TO BE FLOAT, NOT INT
    /** @var float */
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

    /** @var bool */
    private $availability;

    /** @var string */
    private $textStatus;

    /** @var int */
    private $taxClassId;

    /** @var string */
    private $taxClassName;

    /** @var string */
    private $description;

    /** @var string */
    private $shortDescription;

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

    //    TODO OPTIONAL STUFF FROM VARIOUS PLACES

    /** @var array */
    private $extensionAttributes = [];

    /** @var array */
    private $tierPrices = [];

    /** @var array|null */
    private $customAttributes = null;

    /** @var string */
    private $smallImage = '/a/b/small.jpg';

    /** @var string */
    private $thumbnail = '/a/b/small.jpg';

    /** @var string */
    private $optionsContainer = 'container2';

    /** @var string */
    private $activity = '16,11';

    /** @var string */
    private $material = '16,11';

    /** @var string */
    private $gender = '16,11';

    /** @var string */
    private $categoryGear = '16,11';

    /** @var bool */
    private $erinRecommends = true;

    /** @var bool */
    private $new = true;

    /** @var string */
    private $pattern = '195';

    /** @var bool */
    private $ecoCollection = true;

    /** @var int */
    private $displayPriceType = 0;

    /** @var string */
    private $climate = '202,205,207';

    /** @var string */
    private $performanceFabric = '0';

    /** @var bool */
    private $sale = true;

    /** @var array */
    private $childrenData = [];

    /** @var string */
    private $styleGeneral = '136';

    /** @var string */
    private $slug;
//    private $slug = 'minerva-lumatech-and-trade-v-tee-1497';

    /** @var int */
    private $tsk = 1551705236617;

    /** @var string */
    private $parentSku = 'WS08-XXL';

    /** @var string */
    private $color = '58';

    /** @var string */
    private $size = '156';

    /** @var bool */
    private $isConfigured = true;

    //    TODO INTEGRATION BOILERPLATE ONLY

    /** @var string|null */
    private $accessoriesSize = null;

    /** @var string|null */
    private $metaKeyword = null;

    /** @var string|null */
    private $metaTitle = null;

    /** @var string|null */
    private $metaDescription = null;

    /** @var bool|null */
    private $giftMessageAvailable = null;

    /** @var bool|null */
    private $giftWrappingAvailable = false;

    /** @var \DateTime|null */
    private $newsFromDate = null;

    /** @var \DateTime|null */
    private $newsToDate = null;

    /** @var \DateTime|null */
    private $specialFromDate = null;

    /** @var \DateTime|null */
    private $specialToDate = null;

    /** @var bool */
    private $isReccuring = false;

    public function __construct(
        int $entityId,
        ?int $entityTypeId,
        ?int $attributeSetId,
        ?string $type,
        string $sku,
        string $urlKey,
        string $name,
        float $price,
        ?int $status,
        ?int $visibility,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        int $weight,
        string $ean,
        ?string $image,
        bool $availability,
        ?string $textStatus,
        ?int $taxClassId,
        ?string $taxClassName,
        string $description,
        string $shortDescription,
        int $hasOptions,
        int $requiredOptions,
        array $productLinks,
        array $colorOptions,
        array $sizeOptions,
        ?bool $isReccuring
    ) {
        $this->entityId = $entityId;
        $this->entityTypeId = $entityTypeId ?? self::DEFAULT_ENTITY_TYPE_ID;
        $this->attributeSetId = $attributeSetId ?? self::DEFAULT_ATTRIBUTE_SET_ID;
        $this->type = $type ?? self::TYPE_SIMPLE;
        $this->sku = $sku;
        $this->urlKey = $urlKey;
        $this->name = $name;
        $this->price = $price;
        $this->status = $status ?? self::DEFAULT_STATUS;
        $this->visibility = $visibility ?? self::DEFAULT_VISIBILITY;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->weight = $weight;
        $this->ean = $ean;
        $this->image = $image;
        $this->availability = $availability;
        $this->textStatus = $textStatus ?? self::DEFAULT_OPTION_STATUS;
        $this->taxClassId = $taxClassId ?? self::DEFAULT_TAX_CLASS_ID;
        $this->taxClassName = $taxClassName ?? self::DEFAULT_TAX_CLASS_NAME;
        $this->description = $description;
        $this->shortDescription = $shortDescription;
        $this->hasOptions = $hasOptions;
        $this->requiredOptions = $requiredOptions;
        $this->productLinks = $productLinks;
        $this->colorOptions = $colorOptions;
        $this->sizeOptions = $sizeOptions;
        $this->isReccuring = $isReccuring;
        $this->urlPath = $urlKey;
        $this->slug = $urlKey;
    }

    public function toArray(): array
    {
        return [
            self::ENTITY_ID => $this->entityId,
            self::ENTITY_TYPE_ID => $this->entityTypeId,
            self::ATTRIBUTE_SET_ID => $this->attributeSetId,
            self::TYPE => $this->type,
            self::SKU => $this->sku,
            self::URL_KEY => $this->urlKey,
            self::NAME => $this->name,
            self::PRICE => $this->price,
            self::STATUS => $this->status,
            self::VISIBILITY => $this->visibility,
//            self::CREATED_AT => $this->createdAt,
            self::CREATED_AT => $this->createdAt->format(self::DATE_FORMAT),
//            self::UPDATED_AT => $this->updatedAt,
            self::UPDATED_AT => $this->updatedAt->format(self::DATE_FORMAT),
            self::WEIGHT => $this->weight,
            self::EAN => $this->ean,
            self::IMAGE => $this->image,
            self::AVAILABILITY => (string) $this->availability,
            self::TEXT_STATUS => $this->textStatus,
            self::TAX_CLASS_ID => (string) $this->taxClassId,
            self::TAX_CLASS_NAME => $this->taxClassName,
            self::DESCRIPTION => $this->description,
            self::SHORT_DESCRIPTION => $this->shortDescription,
            self::HAS_OPTIONS => $this->hasOptions,
            self::REQUIRED_OPTIONS => $this->requiredOptions,
            self::PRODUCT_LINKS => $this->productLinks,
            self::COLOR_OPTIONS => $this->colorOptions,
            self::SIZE_OPTIONS => $this->sizeOptions,
            self::EXTENSION_ATTRIBUTES => $this->extensionAttributes,
            self::TIER_PRICES => $this->tierPrices,
            self::CUSTOM_ATTRIBUTES => $this->customAttributes,
            self::SMALL_IMAGE => $this->smallImage,
            self::THUMBNAIL => $this->thumbnail,
            self::OPTIONS_CONTAINER => $this->optionsContainer,
            self::ACTIVITY => $this->activity,
            self::MATERIAL => $this->material,
            self::GENDER => $this->gender,
            self::CATEGORY_GEAR => $this->categoryGear,
            self::ERIN_RECOMMENDS => (string) (int) $this->erinRecommends,
            self::NEW => (string) (int) $this->new,
            self::PATTERN => $this->pattern,
            self::ECO_COLLECTION => (string) (int) $this->ecoCollection,
            self::DISPLAY_PRICE_TYPE => (string) $this->displayPriceType,
            self::CLIMATE => $this->climate,
            self::PERFORMANCE_FABRIC => $this->performanceFabric,
            self::SALE => (string) (int) $this->sale,
            self::CHILDREN_DATA => $this->childrenData,
            self::STYLE_GENERAL => $this->styleGeneral,
            self::SLUG => $this->slug,
            self::TSK => $this->tsk,
            self::PARENT_SKU => $this->parentSku,
            self::COLOR => $this->color,
            self::SIZE => $this->size,
            self::IS_CONFIGURED => $this->isConfigured,
            self::ACCESSORIES_SIZE => $this->accessoriesSize,
            self::META_KEYWORD => $this->metaKeyword,
            self::META_TITLE => $this->metaTitle,
            self::META_DESCRIPTION => $this->metaDescription,
            self::GIFT_MESSAGE_AVAILABLE => (int) $this->giftMessageAvailable,
            self::GIFT_WRAPPING_AVAILABLE => (int) $this->giftWrappingAvailable,
            self::NEWS_FROM_DATE => $this->newsFromDate,
            self::NEWS_TO_DATE => $this->newsToDate,
            self::SPECIAL_FROM_DATE => $this->specialFromDate,
            self::SPECIAL_TO_DATE => $this->specialToDate,
            self::IS_RECURRING => $this->isReccuring,
            self::URL_PATH => $this->urlPath,
        ];
    }

}
