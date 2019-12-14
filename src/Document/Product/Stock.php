<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product;

final class Stock implements \JsonSerializable
{
    private const ID = 'stock_id';
    private const QUANTITY = 'qty';
    private const PRODUCT_ID = 'product_id';
    private const ITEM_ID = 'item_id';
    private const IS_QUANTITY_DECIMAL = 'is_qty_decimal';
    private const IS_IN_STOCK = 'is_in_stock';

    //https://docs.vuestorefront.io/guide/data/elasticsearch.html#product-type
    //https://devdocs.magento.com/guides/m1x/api/rest/Resources/inventory.html
    private const MINIMAL_SALE_QUANTITY = 'min_sale_qty';
    private const MAXIMAL_SALE_QUANTITY = 'max_sale_qty';
    private const QUANTITY_INCREMENTS = 'qty_increments';
    private const ENABLE_QUANTITY_INCREMENTS = 'enable_qty_increments';
    private const STATUS_CHANGES_AUTOMATICALLY = 'stock_status_changed_auto';
    private const SHOW_DEFAULT_NOTIFICATION_MESSAGE = 'show_default_notification_message';
    private const LOW_QUANTITY_NOTIFICATION_THRESHOLD = 'notify_stock_qty';
    private const LOW_QUANTITY_DATE = 'low_stock_date';
    private const MANAGE_STOCK = 'manage_stock';
    private const MINIMAL_QUANTITY = 'min_qty';
    private const BACKORDERS = 'backorders';
    private const IS_DIVIDABLE_FOR_SHIPPING = 'is_decimal_divided';
    private const USE_CONFIG_MINIMAL_SALE_QUANTITY = 'use_config_min_sale_qty';
    private const USE_CONFIG_MAXIMAL_SALE_QUANTITY = 'use_config_max_sale_qty';
    private const USE_CONFIG_QUANTITY_INCREMENTS = 'use_config_qty_increments';
    private const USE_CONFIG_ENABLE_QUANTITY_INCREMENTS = 'use_config_enable_qty_inc';
    private const USE_CONFIG_MINIMAL_QUANTITY = 'use_config_min_qty';
    private const USE_CONFIG_LOW_QUANTITY_NOTIFICATION_THRESHOLD = 'use_config_notify_stock_qty';
    private const USE_CONFIG_BACKORDERS = 'use_config_backorders';
    private const USE_CONFIG_MANAGE_STOCK = 'use_config_manage_stock';

//    TODO STOCK, NON-EXISTENT/NULLABLE PROPERTIES
    private const PROPERTIES_THAT_EXIST_IN_DEMO_APP = [
        self::MINIMAL_SALE_QUANTITY,
        self::ITEM_ID,
        self::MINIMAL_QUANTITY,
        self::STATUS_CHANGES_AUTOMATICALLY,
        self::IS_IN_STOCK,
        self::MAXIMAL_SALE_QUANTITY,
        self::SHOW_DEFAULT_NOTIFICATION_MESSAGE,
        self::BACKORDERS,
        self::PRODUCT_ID,
        self::QUANTITY,
        self::IS_DIVIDABLE_FOR_SHIPPING,
        self::IS_QUANTITY_DECIMAL,
        self::LOW_QUANTITY_DATE,
        self::USE_CONFIG_QUANTITY_INCREMENTS,
    ];

    /** @var int */
    private $id;

    /** @var int */
    private $quantity;

    /** @var int */
    private $productId;

    /** @var int */
    private $itemId;

    /** @var bool */
    private $isQuantityDecimal = false;

    /** @var bool */
    private $isInStock = true;

    /** @var int */
    private $minimalSaleQuantity = 1;

    /** @var int */
    private $maximalSaleQuantity = 10000;

    /** @var int */
    private $quantityIncrements = 0;

    /** @var bool */
    private $enableQuantityIncrements = false;

    /** @var bool */
    private $statusChangesAutomatically = false;

    /** @var bool */
    private $showDefaultNotificationMessage = false;

    /** @var int */
    private $lowQuantityNotificationThreshold = 1;

    /** @var \DateTime|null */
    private $lowQuantityDate;

    /** @var bool */
    private $manageStock = true;

    /** @var int */
    private $minimalQuantity = 0;

    /** @var int */
    private $backorders = 0;

    /** @var bool */
    private $isDividableForShipping = false;

    /** @var bool */
    private $useConfigMinimalSaleQuantity = false;

    /** @var bool */
    private $useConfigMaximalSaleQuantity = false;

    /** @var bool */
    private $useConfigQuantityIncrements = false;

    /** @var bool */
    private $useConfigEnableQuantityIncrements = false;

    /** @var bool */
    private $useConfigMinimalQuantity = false;

    /** @var bool */
    private $useConfigLowQuantityNotificationThreshold = false;

    /** @var bool */
    private $useConfigBackorders = false;

    /** @var bool */
    private $useConfigManageStock = false;

    public function __construct(
        int $id,
        int $quantity,
        int $productId,
        int $itemId,
        bool $isInStock,
        int $minimalSaleQuantity,
        int $maximalSaleQuantity,
        int $quantityIncrements,
        bool $enableQuantityIncrements,
        bool $statusChangesAutomatically,
        bool $showDefaultNotificationMessage,
        int $lowQuantityNotificationThreshold,
        ?\DateTime $lowQuantityDate,
        bool $manageStock,
        int $minimalQuantity,
        int $backorders,
        bool $isDividableForShipping,
        bool $useConfigMinimalSaleQuantity,
        bool $useConfigMaximalSaleQuantity,
        bool $useConfigQuantityIncrements,
        bool $useConfigEnableQuantityIncrements,
        bool $useConfigMinimalQuantity,
        bool $useConfigLowQuantityNotificationThreshold,
        bool $useConfigBackorders,
        bool $useConfigManageStock
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->productId = $productId;
        $this->itemId = $itemId;
        $this->isInStock = $isInStock;
        $this->minimalSaleQuantity = $minimalSaleQuantity;
        $this->maximalSaleQuantity = $maximalSaleQuantity;
        $this->quantityIncrements = $quantityIncrements;
        $this->enableQuantityIncrements = $enableQuantityIncrements;
        $this->statusChangesAutomatically = $statusChangesAutomatically;
        $this->showDefaultNotificationMessage = $showDefaultNotificationMessage;
        $this->lowQuantityNotificationThreshold = $lowQuantityNotificationThreshold;
        $this->lowQuantityDate = $lowQuantityDate;
        $this->manageStock = $manageStock;
        $this->minimalQuantity = $minimalQuantity;
        $this->backorders = $backorders;
        $this->isDividableForShipping = $isDividableForShipping;
        $this->useConfigMinimalSaleQuantity = $useConfigMinimalSaleQuantity;
        $this->useConfigMaximalSaleQuantity = $useConfigMaximalSaleQuantity;
        $this->useConfigQuantityIncrements = $useConfigQuantityIncrements;
        $this->useConfigEnableQuantityIncrements = $useConfigEnableQuantityIncrements;
        $this->useConfigMinimalQuantity = $useConfigMinimalQuantity;
        $this->useConfigLowQuantityNotificationThreshold = $useConfigLowQuantityNotificationThreshold;
        $this->useConfigBackorders = $useConfigBackorders;
        $this->useConfigManageStock = $useConfigManageStock;
    }

    public function jsonSerialize(): array
    {
        return [
            self::ID => $this->id,
            self::QUANTITY => $this->quantity,
            self::PRODUCT_ID => $this->productId,
            self::ITEM_ID => $this->itemId,
            self::IS_QUANTITY_DECIMAL => $this->isQuantityDecimal,
            self::IS_IN_STOCK => $this->isInStock,
            self::MINIMAL_SALE_QUANTITY => $this->minimalSaleQuantity,
            self::MAXIMAL_SALE_QUANTITY => $this->maximalSaleQuantity,
            self::QUANTITY_INCREMENTS => $this->quantityIncrements,
            self::ENABLE_QUANTITY_INCREMENTS => $this->enableQuantityIncrements,
            self::STATUS_CHANGES_AUTOMATICALLY => (int) $this->statusChangesAutomatically,
            self::SHOW_DEFAULT_NOTIFICATION_MESSAGE => $this->showDefaultNotificationMessage,
            self::LOW_QUANTITY_NOTIFICATION_THRESHOLD => $this->lowQuantityNotificationThreshold,
            self::LOW_QUANTITY_DATE => $this->lowQuantityDate,
            self::MANAGE_STOCK => $this->manageStock,
            self::MINIMAL_QUANTITY => $this->minimalQuantity,
            self::BACKORDERS => $this->backorders,
            self::IS_DIVIDABLE_FOR_SHIPPING => $this->isDividableForShipping,
            self::USE_CONFIG_MINIMAL_SALE_QUANTITY => (int) $this->useConfigMinimalSaleQuantity,
            self::USE_CONFIG_MAXIMAL_SALE_QUANTITY => $this->useConfigMaximalSaleQuantity,
            self::USE_CONFIG_QUANTITY_INCREMENTS => $this->useConfigQuantityIncrements,
            self::USE_CONFIG_ENABLE_QUANTITY_INCREMENTS => $this->useConfigEnableQuantityIncrements,
            self::USE_CONFIG_MINIMAL_QUANTITY => $this->useConfigMinimalQuantity,
            self::USE_CONFIG_LOW_QUANTITY_NOTIFICATION_THRESHOLD => $this->useConfigLowQuantityNotificationThreshold,
            self::USE_CONFIG_BACKORDERS => $this->useConfigBackorders,
            self::USE_CONFIG_MANAGE_STOCK => $this->useConfigManageStock,
        ];
    }
}
