<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\User;

use Webmozart\Assert\Assert;

final class NewCustomer
{
    private const EMAIL = 'email';
    private const FIRST_NAME = 'firstname';
    private const LAST_NAME = 'lastname';

    /** @var string */
    private $email;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    private function __construct(string $email, string $firstName, string $lastName)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function createFromArray(array $customer): self
    {
        Assert::keyExists($customer, self::EMAIL);
        Assert::keyExists($customer, self::FIRST_NAME);
        Assert::keyExists($customer, self::LAST_NAME);

        return new self(
            $customer[self::EMAIL],
            $customer[self::FIRST_NAME],
            $customer[self::LAST_NAME]
        );
    }

    public function email(): string
    {
        return $this->email;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }
}
