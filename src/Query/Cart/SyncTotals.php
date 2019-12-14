<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\Cart;

use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

final class SyncTotals implements QueryInterface
{
    /** @var string */
    private $token;

    /** @var string */
    private $cartId;

    public function __construct(string $token, string $cartId)
    {
        $this->token = $token;
        $this->cartId = $cartId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}
