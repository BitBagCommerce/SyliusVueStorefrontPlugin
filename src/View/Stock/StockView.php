<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Stock;

final class StockView
{
    /** @var int */
    public $item_id;

    /** @var int */
    public $product_id;

    /** @var int */
    public $stock_id;

    /** @var int */
    public $qty;

    /** @var bool */
    public $is_in_stock;

    /** @var bool */
    public $is_qty_decimal;

    /** @var bool */
    public $show_default_notification_message;

    /** @var bool */
    public $use_config_min_qty;

    /** @var int */
    public $min_qty;

    /** @var int */
    public $use_config_min_sale_qty;

    /** @var int */
    public $min_sale_qty;

    /** @var bool */
    public $use_config_max_sale_qty;

    /** @var int */
    public $max_sale_qty;

    /** @var bool */
    public $use_config_backorders;

    /** @var int */
    public $backorders;

    /** @var bool */
    public $use_config_notify_stock_qty;

    /** @var int */
    public $notify_stock_qty;

    /** @var bool */
    public $use_config_qty_increments;

    /** @var int */
    public $qty_increments;

    /** @var bool */
    public $use_config_enable_qty_inc;

    /** @var bool */
    public $enable_qty_increments;

    /** @var bool */
    public $use_config_manage_stock;

    /** @var bool */
    public $manage_stock;

    /** @var string|null */
    public $low_stock_date;

    /** @var bool */
    public $is_decimal_divided;

    /** @var int */
    public $stock_status_changed_auto;
}
