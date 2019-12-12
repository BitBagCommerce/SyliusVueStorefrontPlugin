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

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestInterface;

final class ChangePasswordRequest implements RequestInterface
{
    /** @var string */
    public $currentPassword;

    /** @var string */
    public $newPassword;

    public function getCommand(): ChangePassword
    {
        return new ChangePassword($this->newPassword);
    }
}
