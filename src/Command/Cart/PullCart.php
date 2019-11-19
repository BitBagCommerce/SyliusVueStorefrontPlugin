<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Cart;

final class PullCart
{
    /** @var string|null */
    private $token;

    /** @var int|string */
    private $cartId;

    public function __construct(?string $token, $cartId)
    {
        $this->token = $token;
        $this->cartId = $cartId;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function cartId(): ?string
    {
        return $this->cartId;
    }
}
