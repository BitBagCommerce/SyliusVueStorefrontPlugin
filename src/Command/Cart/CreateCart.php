<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Cart;

final class CreateCart
{
    /** @var string|null */
    private $token;

    /** @var string */
    private $cartId;

    public function __construct(?string $token, string $cartId)
    {
        $this->token = $token;
        $this->cartId = $cartId;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}
