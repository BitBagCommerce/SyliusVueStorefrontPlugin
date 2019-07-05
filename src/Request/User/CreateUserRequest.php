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

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use Symfony\Component\HttpFoundation\Request;

final class CreateUserRequest
{
    /** @var array|null */
    private $customer;

    /** @var string|null */
    private $password;

    public function __construct(Request $request)
    {
        $this->customer = $request->request->get('customer');
        $this->password = $request->request->get('password');
    }

    public function getCommand(): CreateUser
    {
        return new CreateUser($this->customer, $this->password);
    }
}
