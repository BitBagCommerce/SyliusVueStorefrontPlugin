<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Product;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Category;
use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Price;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;

final class Product implements \JsonSerializable
{
    /** @var int */
    private $entityId;

    /** @var string */
    private $sku;

    /** @var string */
    private $type;

    /** @var string[] */
    private $names;

    /** @var Price[] */
    private $price;

    /** @var Category[] */
    private $category;

    public function __construct(int $entityId, string $sku, string $type, array $names)
    {
        $this->entityId = $entityId;
        $this->sku = $sku;
        $this->type = $type;
        $this->names = $names;
    }

    public static function fromSyliusProduct(ProductInterface $product): self
    {
        $productType = $product->isSimple() ? 'simple' : 'configurable';
        $productTranslations = $product->getTranslations();

        /** @var ProductTranslationInterface $productTranslation */
        foreach ($productTranslations as $productTranslation) {
            $productNames[] = $productTranslation->getName();
        }

        return new self($product->getId(), $product->getCode(), $productType, $productNames);
    }

    public function jsonSerialize(): array
    {
        return [
            'entity_id' => $this->entityId,
            'sku_id' => $this->sku,
            'type_id' => $this->type,
            'name' => $this->names,
        ];
    }
}
