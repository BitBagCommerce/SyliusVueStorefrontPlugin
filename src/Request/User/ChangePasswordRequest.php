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
use Symfony\Component\HttpFoundation\Request;

final class ChangePasswordRequest
{
    /** @var string */
    private $currentPassword;

    /** @var string */
    private $newPassword;

    public function __construct(Request $request)
    {
        $this->currentPassword = $request->request->get('currentPassword');
        $this->newPassword = $request->request->get('newPassword');
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function getCommand(): ChangePassword
    {
        return new ChangePassword($this->newPassword);
    }
}
