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

    /** @var object */
    private $product_option;

    /** @var string */
    private $quoteId;

    /** @var int|null */
    private $item_id;

    public function __construct(string $sku, int $qty, object $product_option, string $quoteId, ?int $item_id)
    {
        $this->sku = $sku;
        $this->qty = $qty;
        $this->product_option = $product_option;
        $this->quoteId = $quoteId;
        $this->item_id = $item_id;
    }
}
