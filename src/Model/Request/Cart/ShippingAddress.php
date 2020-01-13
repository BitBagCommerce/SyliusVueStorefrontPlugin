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
    /** @var string */
    public $countryId;

    /** @var string[]|null */
    public $street;

    /** @var string|null */
    public $postcode;

    /** @var string|null */
    public $city;

    public function getCountryId(): string
    {
        return $this->countryId;
    }

    public function getStreet(): ?string
    {
        if (!$this->street) {
            return null;
        }

        return \implode(' ', $this->street);
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
}
