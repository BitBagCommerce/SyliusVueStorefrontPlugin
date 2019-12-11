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

final class ShippingAddress
{
    private const COUNTRY_ID = 'country_id';

    /** @var string */
    private $countryId;

    public function __construct(string $countryId)
    {
        $this->countryId = $countryId;
    }

    public static function createFromArray(array $array): self
    {
        return new self(
            $array[self::COUNTRY_ID]
        );
    }
}
