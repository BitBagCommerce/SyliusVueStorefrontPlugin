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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestCommandInterface;

final class UpdateCartRequest implements RequestCommandInterface
{
    /** @var string|null */
    public $token;

    /** @var int|string */
    public $cartId;

    /** @var array|null */
    public $cartItem;

    public function getCommand(): CommandInterface
    {
        return new UpdateCart($this->token, $this->cartId, $this->cartItem);
    }
}
