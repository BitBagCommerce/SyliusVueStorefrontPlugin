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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks\Link;

final class ProductLinks
{
    private const PRODUCT_LINKS = 'product_links';

    /** @var Link[] */
    private $links;

    public function __construct(array $links)
    {
        $this->links = $links;
    }

    public function toArray(): array
    {
        return [
            self::PRODUCT_LINKS => $this->links,
        ];
    }
}
