<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem\ProductOption;

final class CartItem
{
    /** @var string */
    public $sku;

    /** @var int */
    public $qty;

    /** @var int|null */
    public $item_id;

    /** @var string|null */
    public $quoteId;

    /** @var ProductOption */
    public $product_option;

    public function getItemId(): ?int
    {
        return $this->item_id;
    }

    public function setItemId(?int $item_id): void
    {
        $this->item_id = $item_id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getQuantity(): int
    {
        return $this->qty;
    }
}
