<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Product;

class ProductPriceInfoView
{
    /** @var int */
    public $final_price;

    /** @var int */
    public $max_price;

    /** @var int */
    public $max_regular_price;

    /** @var int */
    public $minimal_regular_price;

    /** @var int|null */
    public $special_price;

    /** @var int */
    public $minimal_price;

    /** @var int */
    public $regular_price;

    /** @var ProductPriceFormattedView */
    public $formatted_prices;

    /** @var ProductPriceExtensionAttributeView */
    public $extension_attributes;
}
