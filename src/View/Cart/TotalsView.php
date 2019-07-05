<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Cart;

final class TotalsView
{
    /** @var float */
    public $grand_total;

    /** @var float */
    public $base_grand_total;

    /** @var float */
    public $subtotal;

    /** @var float */
    public $base_subtotal;

    /** @var float */
    public $discount_amount;

    /** @var float */
    public $base_discount_amount;

    /** @var float */
    public $subtotal_with_discount;

    /** @var float */
    public $base_subtotal_with_discount;

    /** @var float */
    public $shipping_amount;

    /** @var float */
    public $base_shipping_amount;

    /** @var float */
    public $shipping_discount_amount;

    /** @var float */
    public $base_shipping_discount_amount;

    /** @var float */
    public $tax_amount;

    /** @var float */
    public $base_tax_amount;

    /** @var float|null */
    public $weee_tax_applied_amount;

    /** @var float */
    public $shipping_tax_amount;

    /** @var float */
    public $base_shipping_tax_amount;

    /** @var float */
    public $subtotal_incl_tax;

    /** @var float */
    public $base_subtotal_incl_tax;

    /** @var float */
    public $shipping_incl_tax;

    /** @var float */
    public $base_shipping_incl_tax;

    /** @var float */
    public $base_currency_code;

    /** @var float */
    public $quote_currency_code;

    /** @var float */
    public $items_qty;

    /** @var array */
    public $items;

    /** @var array */
    public $total_segments;
}
