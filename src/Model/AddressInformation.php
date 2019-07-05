<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model;

use Webmozart\Assert\Assert;

final class AddressInformation
{
    private const SHIPPING_ADDRESS = 'shipping_address';
    private const SHIPPING_METHOD_CODE = 'shipping_method_code';
    private const SHIPPING_CARRIER_CODE = 'shipping_carrier_code';

    /** @var Address */
    private $shippingAddress;

    /** @var string */
    private $shippingMethodCode;

    /** @var string */
    private $shippingCarrierCode;

    private function __construct(Address $shippingAddress, string $shippingMethodCode, string $shippingCarrierCode)
    {
        $this->shippingAddress = $shippingAddress;
        $this->shippingMethodCode = $shippingMethodCode;
        $this->shippingCarrierCode = $shippingCarrierCode;
    }

    public static function createFromArray(array $addressInformation): self
    {
        Assert::keyExists($addressInformation, self::SHIPPING_ADDRESS);
        Assert::keyExists($addressInformation, self::SHIPPING_METHOD_CODE);
        Assert::keyExists($addressInformation, self::SHIPPING_CARRIER_CODE);

        return new self(
            Address::createFromArray($addressInformation[self::SHIPPING_ADDRESS]),
            $addressInformation[self::SHIPPING_METHOD_CODE],
            $addressInformation[self::SHIPPING_CARRIER_CODE]
        );
    }
}
