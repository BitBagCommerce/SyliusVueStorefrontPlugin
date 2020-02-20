<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory;

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\AddressView;

class OrderView
{
    /** @var string comma separated IDs */
    public $applied_rule_ids;

    /** @var string */
    public $base_currency_code;

    /** @var int */
    public $base_discount_amount;

    /** @var int */
    public $base_discount_tax_compensation_amount;

    /** @var int */
    public $base_grand_total;

    /** @var int */
    public $base_shipping_amount;

    /** @var int */
    public $base_shipping_discount_amount;

    /** @var int */
    public $base_shipping_incl_tax;

    /** @var int */
    public $base_shipping_tax_amount;

    /** @var int */
    public $base_subtotal;

    /** @var int */
    public $base_subtotal_incl_tax;

    /** @var int */
    public $base_tax_amount;

    /** @var int */
    public $base_to_global_rate;

    /** @var int */
    public $base_to_order_rate;

    /** @var int */
    public $base_total_due;

    /** @var AddressView */
    public $billing_address;

    /** @var int */
    public $billing_address_id;

    /** @var string see DateHelper::DATE_TIME_FORMAT */
    public $created_at;

    /** @var string */
    public $customer_email;

    /** @var string */
    public $customer_firstname;

    /** @var string */
    public $customer_lastname;

    /** @var int */
    public $customer_group_id;

    /** @var int */
    public $customer_is_guest;

    /** @var int */
    public $customer_note_notify;

    /** @var int */
    public $discount_amount;

    /** @var int */
    public $discount_tax_compensation_amount;

    /** @var int */
    public $email_sent;

    /** @var int */
    public $entity_id;

    /** @var OrderExtensionAttributesView */
    public $extension_attributes;

    /** @var string */
    public $global_currency_code;

    /** @var int */
    public $grand_total;

    /** @var string */
    public $increment_id;

    /** @var int */
    public $is_virtual;

    /** @var array|CartItemView[] */
    public $items;

    /** @var string */
    public $order_currency_code;

    /** @var PaymentView */
    public $payment;

    /** @var string */
    public $protect_code;

    /** @var int */
    public $quote_id;

    /** @var int */
    public $shipping_amount;

    /** @var string */
    public $shipping_description;

    /** @var int */
    public $shipping_discount_amount;

    /** @var int */
    public $shipping_discount_tax_compensation_amount;

    /** @var int */
    public $shipping_incl_tax;

    /** @var int */
    public $shipping_tax_amount;

    /** @var string */
    public $state;

    /** @var string */
    public $status;

    /** @var array */
    public $status_histories;

    /** @var string */
    public $store_currency_code;

    /** @var int */
    public $store_id;

    /** @var string */
    public $store_name;

    /** @var float */
    public $store_to_base_rate;

    /** @var float */
    public $store_to_order_rate;

    /** @var int */
    public $subtotal;

    /** @var int */
    public $subtotal_incl_tax;

    /** @var int */
    public $tax_amount;

    /** @var int */
    public $total_due;

    /** @var int */
    public $total_item_count;

    /** @var int */
    public $total_qty_ordered;

    /** @var string see DateHelper::DATE_TIME_FORMAT */
    public $updated_at;

    /** @var float */
    public $weight;
}
