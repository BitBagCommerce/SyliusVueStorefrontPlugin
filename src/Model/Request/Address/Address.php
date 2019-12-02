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

final class Address
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
    private $customerId;

    /** @var Region */
    private $region;

    /** @var int */
    private $regionId;

    /** @var string */
    private $countryId;

    /** @var string */
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
        int $customerId,
        Region $region,
        int $regionId,
        string $countryId,
        string $streets,
        string $company,
        ?string $telephone,
        string $postcode,
        string $city,
        string $firstName,
        string $lastName,
        string $vatId
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->region = $region;
        $this->regionId = $regionId;
        $this->countryId = $countryId;
        $this->street = $streets;
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
            $address[self::CUSTOMER_ID],
            Region::createFromArray($address[self::REGION]),
            $address[self::REGION_ID],
            $address[self::COUNTRY_ID],
            $address[self::STREET],
            $address[self::COMPANY],
            $address[self::TELEPHONE],
            $address[self::POSTCODE],
            $address[self::CITY],
            $address[self::FIRST_NAME],
            $address[self::LAST_NAME],
            $address[self::VAT_ID]
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function customerId(): int
    {
        return $this->customerId;
    }

    public function region(): Region
    {
        return $this->region;
    }

    public function regionId(): int
    {
        return $this->regionId;
    }

    public function countryId(): string
    {
        return $this->countryId;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function company(): string
    {
        return $this->company;
    }

    public function telephone(): ?string
    {
        return $this->telephone;
    }

    public function postcode(): string
    {
        return $this->postcode;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function vatId(): string
    {
        return $this->vatId;
    }
}
