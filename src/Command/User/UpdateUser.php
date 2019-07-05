<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Customer;

final class UpdateUser
{
    /** @var string|null */
    private $token;

    /** @var Customer|;null */
    private $customer;

    public function __construct(?string $token, Customer $customer)
    {
        $this->token = $token;
        $this->customer = $customer;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function customer(): Customer
    {
        return $this->customer;
    }
}
