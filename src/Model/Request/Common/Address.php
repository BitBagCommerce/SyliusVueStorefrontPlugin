<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Common;

class Address
{
    /** @var int */
    public $id;

    /** @var int|null */
    public $customer_id;

    /** @var int */
    public $region_id;

    /** @var string */
    public $region_code;

    /** @var string */
    public $country_id;

    /** @var string[] */
    public $street;

    /** @var string */
    public $company;

    /** @var string|null */
    public $telephone;

    /** @var string */
    public $postcode;

    /** @var string */
    public $city;

    /** @var string */
    public $firstname;

    /** @var string */
    public $lastname;

    /** @var string|null */
    public $vat_id;

    /** workaround for /cart/shipping-information invalid variables' case */
    public $countryId;

    public function getCountryId(): string
    {
        return $this->country_id ?? $this->countryId;
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

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }
}
