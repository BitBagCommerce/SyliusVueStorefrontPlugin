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

final class AddressInformation
{
    private const SHIPPING_ADDRESS = 'shipping_address';
    private const SHIPPING_METHOD_CODE = 'shipping_method_code';
    private const SHIPPING_CARRIER_CODE = 'shipping_carrier_code';

    /** @var ShippingAddress */
    private $shippingAddress;

    /** @var string */
    private $shipping_method_code;

    /** @var string */
    private $shipping_carrier_code;

    public function __construct(
        ShippingAddress $shippingAddress,
        string $shipping_method_code,
        string $shipping_carrier_code
    ) {
        $this->shippingAddress = $shippingAddress;
        $this->shipping_method_code = $shipping_method_code;
        $this->shipping_carrier_code = $shipping_carrier_code;
    }

    public static function createFromArray(array $addressInformation): self
    {
        return new self(
            ShippingAddress::createFromArray($addressInformation[self::SHIPPING_ADDRESS]),
            $addressInformation[self::SHIPPING_METHOD_CODE],
            $addressInformation[self::SHIPPING_CARRIER_CODE]
        );
    }
}
