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

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestCommandInterface;

class ChangePasswordRequest implements RequestCommandInterface
{
    /** @var string */
    public $currentPassword;

    /** @var string */
    public $newPassword;

    public function getCommand(): CommandInterface
    {
        return new ChangePassword($this->newPassword);
    }
}
