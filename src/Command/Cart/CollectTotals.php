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

final class CollectTotals
{
    /** @var string|null */
    private $token;

    /** @var string|null */
    private $cartId;

    /** @var Methods|null */
    private $methods;

    public function __construct(?string $token, ?string $cartId, ?Methods $methods)
    {
        $this->token = $token;
        $this->cartId = $cartId;
        $this->methods = $methods;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function cartId(): ?string
    {
        return $this->cartId;
    }

    public function methods(): ?Methods
    {
        return $this->methods;
    }
}
