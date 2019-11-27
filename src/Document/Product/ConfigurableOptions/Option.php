<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions;

final class Option implements \JsonSerializable
{
    private const ID = 'id';
    private const VALUES = 'values';
    private const PRODUCT_ID = 'product_id';
    private const LABEL = 'label';
    private const POSITION = 'position';
    private const ATTRIBUTE_ID = 'attribute_id';
    private const ATTRIBUTE_CODE = 'attribute_code';

    /** @var int */
    private $id;

    /** @var OptionValue[] */
    private $values;

    /** @var int */
    private $productId;

    /** @var string */
    private $label;

    /** @var int */
    private $position;

    /** @var int */
    private $attributeId;

    /** @var string */
    private $attributeCode;

    public function __construct(
        int $id,
        array $values,
        int $productId,
        string $label,
        int $position,
        int $attributeId,
        string $attributeCode
    ) {
        $this->id = $id;
        $this->values = $values;
        $this->productId = $productId;
        $this->label = $label;
        $this->position = $position;
        $this->attributeId = $attributeId;
        $this->attributeCode = $attributeCode;
    }

    public function jsonSerialize(): array
    {
        return [
            self::ID => $this->id,
            self::VALUES => $this->values,
            self::PRODUCT_ID => $this->productId,
            self::LABEL => $this->label,
            self::POSITION => $this->position,
            self::ATTRIBUTE_ID => (string) $this->attributeId,
            self::ATTRIBUTE_CODE => $this->attributeCode,
        ];
    }
}
