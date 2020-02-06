<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Query\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;

class GetOrderHistory implements QueryInterface
{
    /** @var string|null */
    protected $token;

    /** @var PaginationParameters */
    protected $paginationParameters;

    public function __construct(?string $token, PaginationParameters $paginationParameters)
    {
        $this->token = $token;
        $this->paginationParameters = $paginationParameters;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function paginationParameters(): PaginationParameters
    {
        return $this->paginationParameters;
    }
}
