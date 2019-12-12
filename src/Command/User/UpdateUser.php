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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;

final class UpdateUser implements CommandInterface
{
    /** @var ExistingUser */
    private $customer;

    public function __construct(ExistingUser $customer)
    {
        $this->customer = $customer;
    }

    public function customer(): ExistingUser
    {
        return $this->customer;
    }
}
