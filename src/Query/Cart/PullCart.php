<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\Cart;

use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

class PullCart implements QueryInterface
{
    /** @var string */
    protected $token;

    /** @var int|string */
    protected $cartId;

    public function __construct(string $token, $cartId)
    {
        $this->token = $token;
        $this->cartId = $cartId;
    }

    public function cartId()
    {
        return $this->cartId;
    }
}
