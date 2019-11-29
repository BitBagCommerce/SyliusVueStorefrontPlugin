<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Address;

final class Addresses
{
    private const ID = 'id';
    private const CUSTOMER_ID = 'customer_id';
    private const REGION = 'region';
    private const REGION_ID = 'region_id';
    private const COUNTRY_ID = 'country_id';
    private const STREET = 'street';
    private const COMPANY = 'company';
    private const TELEPHONE = 'telephone';
    private const POSTCODE = 'postcode';
    private const CITY = 'city';
    private const FIRST_NAME = 'firstname';
    private const LAST_NAME = 'lastname';
    private const VAT_ID = 'vat_id';

    /** @var int */
    private $id;

    /** @var int */
    private $customer_id;

    /** @var Region */
    private $region;

    /** @var string */
    private $regionId;

    /** @var string */
    private $countryId;

    /** @var Street */
    private $street;

    /** @var string */
    private $company;

    /** @var string|null */
    private $telephone;

    /** @var string */
    private $postcode;

    /** @var string */
    private $city;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $vatId;

    public function __construct(
        int $id,
        int $customer_id,
        Region $region,
        string $regionId,
        string $countryId,
        Street $street,
        string $company,
        ?string $telephone,
        string $postcode,
        string $city,
        string $firstName,
        string $lastName,
        string $vatId
    ) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->region = $region;
        $this->regionId = $regionId;
        $this->countryId = $countryId;
        $this->street = $street;
        $this->company = $company;
        $this->telephone = $telephone;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->vatId = $vatId;
    }

    public static function createFromArray(array $address): self
    {
        return new self(
            $address[self::ID],
            $address[self::CUSTOMER_ID] ?? null,
            $address[self::REGION] ?? null,
            $address[self::REGION_ID] ?? null,
            $address[self::COUNTRY_ID] ?? null,
            $address[self::STREET] ?? null,
            $address[self::COMPANY] ?? null,
            $address[self::TELEPHONE] ?? null,
            $address[self::POSTCODE] ?? null,
            $address[self::TELEPHONE] ?? null,
            $address[self::FIRST_NAME] ?? null,
            $address[self::LAST_NAME] ?? null,
            $address[self::VAT_ID] ?? null
        );
    }
}
