<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Generator;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Constraints\CartTokenValueIsNotUsed;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UuidGenerator implements UuidGeneratorInteface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function generate(): string
    {
        $uuid = Uuid::uuid4()->toString();

        $this->validator->validate($uuid, new CartTokenValueIsNotUsed());

        return $uuid;
    }
}
