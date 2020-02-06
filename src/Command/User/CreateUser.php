<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\NewCustomer;

class CreateUser implements CommandInterface
{
    /** @var NewCustomer */
    protected $customer;

    /** @var string */
    protected $password;

    public function __construct(NewCustomer $customer, string $password)
    {
        $this->customer = $customer;
        $this->password = $password;
    }

    public function customer(): NewCustomer
    {
        return $this->customer;
    }

    public function password(): string
    {
        return $this->password;
    }
}
