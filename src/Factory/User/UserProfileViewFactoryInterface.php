<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\User;

use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use Sylius\Component\Customer\Model\CustomerInterface as SyliusCustomerInterface;

interface UserProfileViewFactoryInterface
{
    public function create(SyliusCustomerInterface $syliusCustomer): UserProfileView;
}
