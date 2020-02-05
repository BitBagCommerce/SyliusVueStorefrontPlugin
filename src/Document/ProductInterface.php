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

interface ProductInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public const ENTITY_ID = 'id';

    public const ATTRIBUTE_SET_ID = 'attribute_set_id';

    public const TYPE = 'type_id';

    public const SKU = 'sku';

    public const URL_KEY = 'url_key';

    public const NAME = 'name';

    public const PRICE = 'price';

    public const STATUS = 'status';

    public const VISIBILITY = 'visibility';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    public const WEIGHT = 'weight';

    public const EAN = 'ean';

    public const IMAGE = 'image';

    public const AVAILABILITY = 'availability';

    public const TEXT_STATUS = 'option_text_status';

    public const TAX_CLASS_ID = 'tax_class_id';

    public const TEXT_TAX_CLASS_ID = 'option_text_tax_class_id';

    public const DESCRIPTION = 'description';

    public const SHORT_DESCRIPTION = 'short_description';

    public const STOCK = 'stock';

    public const STOCK_ITEM = 'stock_item';

    public const CATEGORY = 'category';

    public const MEDIA_GALLERY = 'media_gallery';

    public const CATEGORY_IDS = 'category_ids';

    public const HAS_OPTIONS = 'has_options';

    public const REQUIRED_OPTIONS = 'required_options';

    public const PRODUCT_LINKS = 'product_links';

    public const COLOR_OPTIONS = 'color_options';

    public const SIZE_OPTIONS = 'size_options';

    public const CONFIGURABLE_OPTIONS = 'configurable_options';

    public const CONFIGURABLE_CHILDREN = 'configurable_children';

    public function toElasticArray(): array;
}
