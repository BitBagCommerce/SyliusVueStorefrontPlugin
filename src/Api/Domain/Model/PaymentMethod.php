<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Api\Domain\Model;

final class PaymentMethod implements \JsonSerializable
{
    private const CODE = 'code';
    private const NAME = 'title';

    /** @var string */
    private $code;

    /** @var string */
    private $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            self::CODE => $this->code,
            self::NAME => $this->name,
        ];
    }
}
