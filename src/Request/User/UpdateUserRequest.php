<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestInterface;

final class UpdateUserRequest implements RequestInterface
{
    /** @var ExistingUser */
    public $customer;

    public function getCommand(): UpdateUser
    {
        return new UpdateUser(ExistingUser::createFromArray($this->customer));
    }
}
