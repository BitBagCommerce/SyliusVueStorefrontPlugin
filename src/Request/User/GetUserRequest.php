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

use BitBag\SyliusVueStorefrontPlugin\Command\User\GetUser;
use Symfony\Component\HttpFoundation\Request;

final class GetUserRequest
{
    /** @var string|null */
    private $token;

    public function __construct(Request $request)
    {
        $this->token = $request->query->get('token');
    }

    public function getCommand(): GetUser
    {
        return new GetUser($this->token);
    }
}
