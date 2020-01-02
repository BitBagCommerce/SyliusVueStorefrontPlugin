<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\Cart;

use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

final class GetAppliedCoupon implements QueryInterface
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
