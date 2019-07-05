<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use Symfony\Component\HttpFoundation\Request;

final class ResetPasswordRequest
{
    /** @var string|null */
    private $email;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email');
    }

    public function getCommand(): ResetPassword
    {
        return new ResetPassword($this->email);
    }
}
