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

final class Methods
{
    private const PAYMENT_METHOD = 'paymentMethod';
    private const SHIPPING_CARRIER_CODE = 'shippingCarrierCode';
    private const SHIPPING_METHOD_CODE = 'shippingMethodCode';

    /** @var PaymentMethod */
    private $paymentMethod;

    /** @var string */
    private $shippingCarrierCode;

    /** @var string */
    private $shippingMethodCode;

    private function __construct(PaymentMethod $paymentMethod, string $shippingCarrierCode, string $shippingMethodCode)
    {
        $this->paymentMethod = $paymentMethod;
        $this->shippingCarrierCode = $shippingCarrierCode;
        $this->shippingMethodCode = $shippingMethodCode;
    }

    public static function createFromArray(array $methods): self
    {
        Assert::keyExists($methods, self::PAYMENT_METHOD);
        Assert::keyExists($methods, self::SHIPPING_CARRIER_CODE);
        Assert::keyExists($methods, self::SHIPPING_METHOD_CODE);

        return new self(
            PaymentMethod::createFromArray($methods[self::PAYMENT_METHOD]),
            $methods[self::SHIPPING_CARRIER_CODE],
            $methods[self::SHIPPING_METHOD_CODE]
        );
    }
}
