<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https//bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Cart;

final class Items
{
    /** @var int */
    public $item_id;

    /** @var int */
    public $price;

    /** @var int */
    public $qty;

    /** @var int */
    public $row_total;

    /** @var int */
    public $row_total_with_discount;

    /** @var float */
    public $tax_amount;

    /** @var int */
    public $tax_percent;

    /** @var float */
    public $discount_amount;

    /** @var int */
    public $discount_percent;

    /** @var float */
    public $price_incl_tax;

    /** @var float */
    public $row_total_incl_tax;

    /** @var float */
    public $base_row_total_incl_tax;

    /** @var array */
    public $options;

    /** @var string */
    public $name;
}
