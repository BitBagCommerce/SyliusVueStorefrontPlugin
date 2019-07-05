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

final class ChangePassword
{
    /** @var string|null */
    private $token;

    /** @var string|null */
    private $currentPassword;

    /** @var string|null */
    private $newPassword;

    public function __construct(?string $token, ?string $currentPassword, ?string $newPassword)
    {
        $this->token = $token;
        $this->currentPassword = $currentPassword;
        $this->newPassword = $newPassword;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function currentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function newPassword(): ?string
    {
        return $this->newPassword;
    }
}
