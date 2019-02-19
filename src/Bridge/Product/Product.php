<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Product;

use Sylius\Component\Core\Model\ProductInterface;

final class Product implements \JsonSerializable
{
    /** @var int */
    private $productId;

    /** @var string */
    private $itemId;

    /** @var int */
    private $stock;

    /** @var bool */
    private $isInStock;

    public function __construct(int $productId, string $itemId)
    {
        $this->productId = $productId;
        $this->itemId = $itemId;
    }

    public static function fromSyliusProduct(ProductInterface $product): self
    {
        return new self($product->getId(), $product->getCode());
    }

    public function jsonSerialize(): array
    {
        return [
            'item_id' => $this->itemId,
            'product_id' => $this->productId,
        ];
    }
}
