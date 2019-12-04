<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\User;

use Webmozart\Assert\Assert;

final class NewCustomer
{
    /** @var string */
    private $email;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    private function __construct(string $email, string $firstName, string $lastName)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
//
    public function __set($key, $value)
    {
        $this->$key = $value;
    }


    //    public function email(): string
//    {
//        return $this->email;
//    }
//
//    public function firstName(): string
//    {
//        return $this->firstName;
//    }
//
//    public function lastName(): string
//    {
//        return $this->lastName;
//    }
//
//    public function setEmail(string $email): void
//    {
//        $this->email = $email;
//    }
//
//    public function setFirstName(string $firstName): void
//    {
//        $this->firstName = $firstName;
//    }
//
//    public function setLastName(string $lastName): void
//    {
//        $this->lastName = $lastName;
//    }
}
