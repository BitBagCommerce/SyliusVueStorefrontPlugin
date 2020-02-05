<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks;

final class Link implements \JsonSerializable
{
    private const ALLOWED_TYPES = ['related', 'upsell', 'crosssell', 'associated'];

    private const SKU = 'sku';

    private const TYPE = 'link_type';

    private const POSITION = 'position';

    private const PRODUCT_SKU = 'linked_product_sku';

    private const PRODUCT_TYPE = 'linked_product_type';

    /** @var string */
    private $sku;

    /** @var string */
    private $type;

    /** @var int */
    private $position;

    /** @var string */
    private $productSku;

    /** @var string */
    private $productType;

    public function __construct(string $sku, string $type, int $position, string $productSku, string $productType)
    {
        $this->sku = $sku;
        $this->type = $type;
        $this->position = $position;
        $this->productSku = $productSku;
        $this->productType = $productType;
    }

    public function jsonSerialize(): array
    {
        return [
            self::SKU => $this->sku,
            self::TYPE => $this->type,
            self::POSITION => $this->position,
            self::PRODUCT_SKU => $this->productSku,
            self::PRODUCT_TYPE => $this->productType,
        ];
    }
}
