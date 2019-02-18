<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Product;

use Sylius\Component\Core\Model\Product as SyliusProduct;

final class Product implements \JsonSerializable
{
    /** @var string */
    private $sku;

    private function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public static function fromSyliusProduct(SyliusProduct $product): self
    {
        return new self($product->getCode());
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function jsonSerialize(): array
    {
        return [
            'sku' => $this->sku,
        ];
    }
}
