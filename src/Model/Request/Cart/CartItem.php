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

final class CartItem
{
    /** @var string */
    private $sku;

    /** @var int */
    private $qty;

    /** @var int|null */
    private $item_id;

    /** @var string|null */
    private $quoteId;

    /** @var object|null */
    private $product_option;

    public function __construct(
        string $sku,
        int $qty,
        ?int $item_id = null,
        ?string $quoteId = null,
        ?object $product_option = null
    ) {
        $this->sku = $sku;
        $this->qty = $qty;
        $this->item_id = $item_id;
        $this->quoteId = $quoteId;
        $this->product_option = $product_option;
    }

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
