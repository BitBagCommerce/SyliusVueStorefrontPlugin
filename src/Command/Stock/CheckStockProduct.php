<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Stock;

final class CheckStockProduct
{
    /** @var string */
    private $sku;

    public function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public function sku(): string
    {
        return $this->sku;
    }
}
