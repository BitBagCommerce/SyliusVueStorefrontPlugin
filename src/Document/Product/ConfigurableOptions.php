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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions\Option;

final class ConfigurableOptions
{
    private const OPTIONS = 'configurable_options';

    /** @var Option[] */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function toArray(): array
    {
        return [
            self::OPTIONS => $this->options,
        ];
    }
}
