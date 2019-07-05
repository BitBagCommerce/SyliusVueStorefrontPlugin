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

final class CreateUser
{
    /** @var Customer|null */
    private $customer;

    /** @var string|null */
    private $password;

    public function __construct(?Customer $customer, ?string $password)
    {
        $this->customer = $customer;
        $this->password = $password;
    }

    public function customer(): ?Customer
    {
        return $this->customer;
    }

    public function password(): ?string
    {
        return $this->password;
    }
}
