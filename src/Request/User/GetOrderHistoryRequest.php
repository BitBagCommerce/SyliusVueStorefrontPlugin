<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\User\GetOrderHistory;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestQueryInterface;

final class GetOrderHistoryRequest implements RequestQueryInterface
{
    /** @var string|null */
    public $token;

    /** @var string */
    public $pageSize;

    /** @var string */
    public $currentPage;

    public function getQuery(): QueryInterface
    {
        return new GetOrderHistory($this->token, new PaginationParameters($this->pageSize, $this->currentPage));
    }
}
