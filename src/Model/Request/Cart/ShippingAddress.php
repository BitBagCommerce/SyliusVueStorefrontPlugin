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

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\OrderAddressInterface;

final class ShippingAddress implements OrderAddressInterface
{
    /** @var string */
    public $country_id;

    /** @var string[] */
    public $street;

    /** @var string|null */
    public $postcode;

    /** @var string|null */
    public $city;

    public function getCountryId(): string
    {
        return $this->country_id;
    }

    public function getStreet(): ?string
    {
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
