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

use BitBag\SyliusVueStorefrontPlugin\Command\User\GetOrderHistory;
use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestQueryInterface;

final class GetOrderHistoryRequest implements RequestQueryInterface
{
    /** @var string|null */
    public $token;

    public function getQuery(): QueryInterface
    {
        return new GetOrderHistory($this->token);
    }
}
