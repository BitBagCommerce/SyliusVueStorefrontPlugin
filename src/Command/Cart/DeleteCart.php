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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem;

final class DeleteCart implements CommandInterface
{
    /** @var CartItem */
    private $cartItem;

    /** @var string */
    private $orderToken;

    public function __construct(CartItem $cartItem, string $tokenValue)
    {
        $this->cartItem = $cartItem;
        $this->orderToken = $tokenValue;
    }

    public function cartItem(): CartItem
    {
        return $this->cartItem;
    }

    public function orderToken(): string
    {
        return $this->orderToken;
    }
}
