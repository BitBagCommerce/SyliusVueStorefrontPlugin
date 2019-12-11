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

final class TotalsView
{
    /** @var float */
    public $grand_total;

    /** @var float */
    public $subtotal;

    /** @var float */
    public $discount_amount;

    /** @var float */
    public $subtotal_with_discount;

    /** @var float */
    public $shipping_amount;

    /** @var float */
    public $shipping_discount_amount;

    /** @var float */
    public $tax_amount;

    /** @var float */
    public $shipping_tax_amount;

    /** @var float */
    public $base_shipping_tax_amount;

    /** @var float */
    public $subtotal_incl_tax;

    /** @var float */
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
