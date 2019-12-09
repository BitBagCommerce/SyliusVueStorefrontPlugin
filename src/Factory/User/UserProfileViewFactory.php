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

use BitBag\SyliusVueStorefrontPlugin\Factory\AddressViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Helper\DateHelper;
use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use Sylius\Component\Core\Model\CustomerInterface as SyliusCustomerInterface;

final class UserProfileViewFactory implements UserProfileViewFactoryInterface
{
    /** @var AddressViewFactoryInterface */
    private $addressViewFactory;

    public function __construct(AddressViewFactoryInterface $addressViewFactory)
    {
        $this->addressViewFactory = $addressViewFactory;
    }

    public function create(SyliusCustomerInterface $syliusCustomer): UserProfileView
    {
        $userProfileView = new UserProfileView();
        $userProfileView->id = $syliusCustomer->getId();
        $userProfileView->group_id = 1;
        $userProfileView->default_shipping = $syliusCustomer->getDefaultAddress() ? $syliusCustomer->getDefaultAddress()->getId() : '';
        $userProfileView->created_at = $syliusCustomer->getCreatedAt()->format(DateHelper::DATE_TIME_FORMAT);
        $userProfileView->updated_at = $syliusCustomer->getUpdatedAt()->format(DateHelper::DATE_TIME_FORMAT);
        $userProfileView->email = $syliusCustomer->getEmail();
        $userProfileView->firstname = $syliusCustomer->getFirstName();
        $userProfileView->lastname = $syliusCustomer->getLastName();

        $userProfileView->store_id = 1;
        $userProfileView->website_id = 1;

        foreach ($syliusCustomer->getAddresses() as $address) {
            $userProfileView->addresses[] = $this->addressViewFactory->create($address);
        }

        $userProfileView->disable_auto_group_change = 0;

        return $userProfileView;
    }
}
