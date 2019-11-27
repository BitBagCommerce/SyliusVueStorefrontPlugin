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

use BitBag\SyliusVueStorefrontPlugin\Model\CartItem;

final class UpdateCart
{
    /** @var string|null */
    private $token;

    /** @var string|null */
    private $cartId;

    /** @var CartItem|null */
    private $cartItem;

    public function __construct(?string $token, ?string $cartId, ?CartItem $cartItem)
    {
        $this->token = $token;
        $this->cartId = $cartId;
        $this->cartItem = $cartItem;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function cartId(): ?string
    {
        return $this->cartId;
    }

    public function cartItem(): ?CartItem
    {
        return $this->cartItem;
    }
}
