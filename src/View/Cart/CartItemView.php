<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Cart;

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ProductOption;

final class CartItemView
{
    /** @var int */
    public $amount_refunded;

    /** @var string comma separated IDs */
    public $applied_rule_ids;

    /** @var int */
    public $base_amount_refunded;

    /** @var float */
    public $base_discount_amount;

    /** @var float */
    public $base_discount_invoiced;

    /** @var int */
    public $base_discount_tax_compensation_amount;

    /** @var float */
    public $base_original_price;

    /** @var float */
    public $base_price;

    /** @var float */
    public $base_price_incl_tax;

    /** @var float */
    public $base_row_invoiced;

    /** @var float */
    public $base_row_total;

    /** @var float */
    public $base_row_total_incl_tax;

    /** @var float */
    public $base_tax_amount;

    /** @var float */
    public $base_tax_invoiced;

    /** @var string see DateHelper::DATE_TIME_FORMAT */
    public $created_at;

    /** @var float */
    public $discount_amount;

    /** @var float */
    public $discount_invoiced;

    /** @var int */
    public $discount_percent;

    /** @var int */
    public $discount_tax_compensation_amount;

    /** @var int */
    public $free_shipping;

    /** @var int */
    public $is_qty_decimal;

    /** @var int */
    public $is_virtual;

    /** @var int */
    public $item_id;

    /** @var string */
    public $name;

    /** @var int */
    public $no_discount;

    /** @var string[] */
    public $options;

    /** @var int */
    public $order_id;

    /** @var float */
    public $original_price;

    /** @var float */
    public $price;

    /** @var float */
    public $price_incl_tax;

    /** @var int */
    public $product_id;

    /** @var ProductOption */
    public $product_option;

    /** @var string */
    public $product_type;

    /** @var int */
    public $qty;

    /** @var int */
    public $qty_canceled;

    /** @var int */
    public $qty_invoiced;

    /** @var int */
    public $qty_ordered;

    /** @var int */
    public $qty_refunded;

    /** @var int */
    public $qty_shipped;

    /** @var string */
    public $quote_id;

    /** @var int */
    public $quote_item_id;

    /** @var float */
    public $row_invoiced;

    /** @var float */
    public $row_total;

    /** @var float */
    public $row_total_incl_tax;

    /** @var float */
    public $row_total_with_discount;

    /** @var int */
    public $row_weight;

    /** @var string */
    public $sku;

    /** @var int */
    public $store_id;

    /** @var float */
    public $tax_amount;

    /** @var float */
    public $tax_invoiced;

    /** @var int */
    public $tax_percent;

    /** @var string see DateHelper::DATE_TIME_FORMAT */
    public $updated_at;

    /** @var int */
    public $weight;
}
