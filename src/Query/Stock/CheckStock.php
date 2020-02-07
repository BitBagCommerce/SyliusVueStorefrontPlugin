<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\Stock;

use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

class CheckStock implements QueryInterface
{
    /** string */
    protected $sku;

    public function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    public function sku(): string
    {
        return $this->sku;
    }
}
