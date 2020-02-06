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

class ShippingMethodsView
{
    /** @var string */
    public $carrier_code;

    /** @var string */
    public $method_code;

    /** @var string */
    public $carrier_title;

    /** @var string */
    public $method_title;

    /** @var int */
    public $amount;

    /** @var int */
    public $base_amount;

    /** @var bool */
    public $available;

    /** @var string|null */
    public $error_message;

    /** @var int */
    public $price_excl_tax;

    /** @var int */
    public $price_incl_tax;
}
