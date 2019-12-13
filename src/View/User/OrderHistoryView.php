<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\User;

use BitBag\SyliusVueStorefrontPlugin\View\Common\SearchCriteria\SearchCriteriaView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderView;

final class OrderHistoryView
{
    /** @var array|OrderView[] */
    public $items;

    /** @var SearchCriteriaView */
    public $search_criteria;

    /** @var int */
    public $total_count;
}
