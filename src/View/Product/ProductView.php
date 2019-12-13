<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https//bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\Product;

use BitBag\SyliusVueStorefrontPlugin\View\Common\SearchCriteria\SearchCriteriaView;

final class ProductView
{
    /** @var int */
    public $id;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var int */
    public $price;

    /** @var int */
    public $status;

    /** @var int */
    public $visibility;

    /** @var string */
    public $type_id;

    /** @var \DateTime */
    public $created_at;

    /** @var \DateTime */
    public $updated_at;

    /** @var array */
    public $product_links;

    /** @var array */
    public $tier_prices;

    /** @var ProductCustomAttributesView[]*/
    public $custom_attributes;

    /** @var SearchCriteriaView */
    public $search_criteria;

    /** @var int */
    public $total_count;
}
