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
use BitBag\SyliusVueStorefrontPlugin\Request\RequestInterface;

final class GetOrderHistoryRequest implements RequestInterface
{
    /** @var string|null */
    public $token;

    public function getCommand(): GetOrderHistory
    {
        return new GetOrderHistory($this->token);
    }
}
