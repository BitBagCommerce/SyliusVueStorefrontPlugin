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

class ShippingTotalView
{
    /** @var int */
    public $base_shipping_amount;

    /** @var int */
    public $base_shipping_discount_amount;

    /** @var int */
    public $base_shipping_incl_tax;

    /** @var int */
    public $base_shipping_tax_amount;

    /** @var int */
    public $shipping_amount;

    /** @var int */
    public $shipping_discount_amount;

    /** @var int */
    public $shipping_discount_tax_compensation_amount;

    /** @var int */
    public $shipping_incl_tax;

    /** @var int */
    public $shipping_tax_amount;
}
