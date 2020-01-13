<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product;

final class Stock implements \JsonSerializable
{
    private const PRODUCT_ID = 'product_id';
    private const QUANTITY = 'qty';
    private const IS_IN_STOCK = 'is_in_stock';

    /** @var int */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var bool */
    private $isInStock;

    public function __construct(
        int $productId,
        int $quantity,
        bool $isInStock
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->isInStock = $isInStock;
    }

    public function jsonSerialize(): array
    {
        return [
            self::PRODUCT_ID => $this->productId,
            self::QUANTITY => $this->quantity,
            self::IS_IN_STOCK => $this->isInStock,
        ];
    }
}
