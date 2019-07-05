<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model;

final class CartItem
{
    private const SKU = 'sku';
    private const QUANTITY = 'quantity';
    private const PRODUCT_OPTION = 'product_option';
    private const QUOTE_ID = 'quoteId';

    /** @var string */
    private $sku;

    /** @var int */
    private $quantity;

    /** @var ProductOption */
    private $productOption;

    /** @var string */
    private $quoteId;

    public function __construct(string $sku, int $quantity, ProductOption $productOption, string $quoteId)
    {
        $this->sku = $sku;
        $this->quantity = $quantity;
        $this->productOption = $productOption;
        $this->quoteId = $quoteId;
    }
}
