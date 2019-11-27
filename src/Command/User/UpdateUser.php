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

use BitBag\SyliusVueStorefrontPlugin\Model\User;

final class UpdateUser
{
    /** @var string|null */
    private $token;

    /** @var User|;null */
    private $customer;

    public function __construct(?string $token, User $customer)
    {
        $this->token = $token;
        $this->customer = $customer;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function customer(): User
    {
        return $this->customer;
    }
}
