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
    private const STREET = 'street';
    private const POSTCODE = 'postcode';
    private const CITY = 'city';

    /** @var string */
    private $country_id;

    /** @var string|null */
    private $street;

    /** @var string|null */
    private $postcode;

    /** @var string|null */
    private $city;

    public function __construct(
        string $country_id,
        ?string $street,
        ?string $postcode,
        ?string $city
    ) {
        $this->country_id = $country_id;
        $this->street = $street;
        $this->postcode = $postcode;
        $this->city = $city;
    }

    public function getCountryId(): string
    {
        return $this->country_id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
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
