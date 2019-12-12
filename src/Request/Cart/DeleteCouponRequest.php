<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\DeleteCoupon;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestInterface;

final class DeleteCouponRequest implements RequestInterface
{
    /** @var string|null */
    public $token;

    /** @var string */
    public $cartId;

    public function getCommand(): DeleteCoupon
    {
        return new DeleteCoupon($this->token, $this->cartId);
    }
}
