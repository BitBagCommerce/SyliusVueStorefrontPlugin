<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use Sylius\Component\Core\Model\CustomerInterface;

interface OrderHistoryViewFactoryInterface
{
    public function create(CustomerInterface $syliusCustomer, PaginationParameters $paginationParameters): OrderHistoryView;
}
