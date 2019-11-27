<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View;

final class AddressView
{
    /** @var int */
    public $id;

    /** @var int */
    public $customer_id;

    /** @var string */
    public $firstname;

    /** @var string */
    public $lastname;

    /** @var array|string[] */
    public $street;

    /** @var string */
    public $city;

    /** @var string */
    public $country_id;

    /** @var string */
    public $postcode;
}
