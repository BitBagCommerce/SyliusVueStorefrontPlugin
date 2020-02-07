<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals;

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;

class TotalsView
{
    /** @var int */
    public $grand_total;

    /** @var int */
    public $base_grand_total;

    /** @var int */
    public $subtotal;

    /** @var int */
    public $base_subtotal;

    /** @var string */
    public $coupon_code;

    /** @var int */
    public $discount_amount;

    /** @var int */
    public $subtotal_with_discount;

    /** @var int */
    public $shipping_amount;

    /** @var int */
    public $shipping_discount_amount;

    /** @var int */
    public $tax_amount;

    /** @var int */
    public $shipping_tax_amount;

    /** @var int */
    public $base_shipping_tax_amount;

    /** @var int */
    public $subtotal_incl_tax;

    /** @var int */
    public $shipping_incl_tax;

    /** @var string */
    public $base_currency_code;

    /** @var string */
    public $quote_currency_code;

    /** @var int */
    public $items_qty;

    /** @var array|CartItemView[] */
    public $items;

    /** @var array|TotalSegmentView[] */
    public $total_segments;
}
