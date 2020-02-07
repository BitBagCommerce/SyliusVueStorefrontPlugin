<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;

class CreateCart implements CommandInterface
{
    /** @var string|null */
    protected $token;

    /** @var string */
    protected $cartId;

    public function __construct(?string $token)
    {
        $this->token = $token;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function setCartId(string $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}
