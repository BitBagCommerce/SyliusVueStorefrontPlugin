<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Common;

class PaginationParameters
{
    /** @var int */
    private $pageSize;

    /** @var int */
    private $currentPage;

    public function __construct(string $pageSize, string $currentPage)
    {
        $this->pageSize = (int) $pageSize;
        $this->currentPage = (int) $currentPage;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
}
