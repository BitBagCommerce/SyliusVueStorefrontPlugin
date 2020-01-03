<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\BillingAddress;

final class AddressInformation
{
    /** @var ShippingAddress */
    public $shippingAddress;

    /** @var BillingAddress */
    public $billingAddress;

    /** @var string */
    public $shipping_method_code;

    /** @var string */
    public $shipping_carrier_code;

    /** @var string */
    public $payment_method_code;

//    /** @var null|object */
//    public $payment_method_additional;

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function getShippingCarrierCode(): string
    {
        return $this->shipping_carrier_code;
    }
}
