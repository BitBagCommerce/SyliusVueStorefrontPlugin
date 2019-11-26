<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;

final class UpdateUser
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
