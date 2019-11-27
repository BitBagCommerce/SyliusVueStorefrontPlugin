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

final class OptionValue implements \JsonSerializable
{
    private const INDEX = 'value_index';
    private const LABEL = 'label';

    /** @var int */
    private $index;

    /** @var string|null */
    private $label;

    public function __construct(int $index, ?string $label)
    {
        $this->index = $index;
        $this->label = $label;
    }

    public function jsonSerialize(): array
    {
        return [
            self::INDEX => $this->index,
            self::LABEL => $this->label,
        ];
    }
}
