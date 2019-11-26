<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Response;

use Webmozart\Assert\Assert;

final class Address
{
    private const COUNTRY_ID = 'country_id';
    private const VAT_ID = 'vat_id';
    private const REGION_ID = 'region_id';
    private const REGION_CODE = 'region_code';
    private const REGION_NAME = 'region';
    private const CITY = 'city';
    private const POSTCODE = 'postcode';
    private const STREET = 'street';
    private const COMPANY = 'company';
    private const TELEPHONE = 'telephone';
    private const FIRST_NAME = 'firstname';
    private const LAST_NAME = 'lastname';
    private const EMAIL = 'email';

    /** @var string */
    private $countryId;

    /** @var string */
    private $vatId;

    /** @var string */
    private $regionId;

    /** @var string */
    private $regionCode;

    /** @var string */
    private $regionName;

    /** @var string */
    private $city;

    /** @var string */
    private $postcode;

    /** @var string */
    private $street;

    /** @var string */
    private $company;

    /** @var string|null */
    private $telephone;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $email;

    public function __construct(
        string $countryId,
        string $vatId = null,
        string $regionId = null,
        string $regionCode = null,
        string $regionName = null,
        string $city = null,
        string $postcode = null,
        string $street = null,
        string $company = null,
        string $telephone = null,
        string $firstName = null,
        string $lastName = null,
        string $email = null
    ) {
        $this->countryId = $countryId;
        $this->vatId = $vatId;
        $this->regionId = $regionId;
        $this->regionCode = $regionCode;
        $this->regionName = $regionName;
        $this->city = $city;
        $this->postcode = $postcode;
        $this->street = $street;
        $this->company = $company;
        $this->telephone = $telephone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public static function createFromArray(array $address): self
    {
        Assert::keyExists($address, self::COUNTRY_ID);

        return new self(
            $address[self::COUNTRY_ID],
            $address[self::VAT_ID] ?? null,
            $address[self::REGION_ID] ?? null,
            $address[self::REGION_CODE] ?? null,
            $address[self::REGION_NAME] ?? null,
            $address[self::CITY] ?? null,
            $address[self::POSTCODE] ?? null,
            $address[self::STREET] ?? null,
            $address[self::COMPANY] ?? null,
            $address[self::TELEPHONE] ?? null,
            $address[self::FIRST_NAME] ?? null,
            $address[self::LAST_NAME] ?? null,
            $address[self::EMAIL] ?? null
        );
    }
}
