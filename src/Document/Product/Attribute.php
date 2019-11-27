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

final class Attribute implements \JsonSerializable
{
    private const CODE = 'attribute_code';
    private const VALUE = 'value';

    /** @var string */
    private $code;

    /** @var string|string[]|mixed */
    private $value;

    public function __construct(string $code, $value)
    {
        $this->code = $code;
        $this->value = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            self::CODE => $this->code,
            self::VALUE => $this->value,
        ];
    }
}
