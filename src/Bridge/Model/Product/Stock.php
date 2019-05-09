<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product;

use Sylius\Component\Core\Model\ProductVariantInterface as SyliusProductVariantInterface;

final class Stock
{
    private const ID = 'stock_id';
    private const QUANTITY = 'qty';
    private const PRODUCT_ID = 'product_id';
    private const ITEM_ID = 'item_id';
    private const IS_QUANTITY_DECIMAL = 'is_qty_decimal';
    private const IS_IN_STOCK = 'is_in_stock';

    /** @var int */
    private $id;

    /** @var int */
    private $quantity;

    /** @var int */
    private $productId;

    /** @var int */
    private $itemId;

    /** @var bool */
    private $isQuantityDecimal;

    /** @var bool */
    private $isInStock;

    public function __construct(
        int $id,
        int $quantity,
        int $productId,
        int $itemId,
        bool $isQuantityDecimal,
        bool $isInStock
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->productId = $productId;
        $this->itemId = $itemId;
        $this->isQuantityDecimal = $isQuantityDecimal;
        $this->isInStock = $isInStock;
    }

    public static function fromSyliusProductVariant(SyliusProductVariantInterface $productVariant): self
    {
        return new self(
            5,
            5,
            5,
            5,
            true,
            true
        );
    }

}
