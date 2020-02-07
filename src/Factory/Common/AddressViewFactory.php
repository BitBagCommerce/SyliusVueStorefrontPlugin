<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Common;

use BitBag\SyliusVueStorefrontPlugin\Factory\Common\Address\RegionViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Common\AddressView;
use Sylius\Component\Core\Model\AddressInterface as SyliusAddressInterface;

final class AddressViewFactory implements AddressViewFactoryInterface
{
    /** @var string */
    private $addressViewClass;

    /** @var RegionViewFactoryInterface */
    private $regionView;

    public function __construct(string $addressViewClass, RegionViewFactoryInterface $regionView)
    {
        $this->addressViewClass = $addressViewClass;
        $this->regionView = $regionView;
    }

    public function create(SyliusAddressInterface $syliusAddress): AddressView
    {
        /** @var AddressView $addressView */
        $addressView = new $this->addressViewClass();
        $addressView->id = $syliusAddress->getId();
        $addressView->region = $this->regionView->create($syliusAddress);
        $addressView->customer_id = $syliusAddress->getCustomer() ? $syliusAddress->getCustomer()->getId() : 0;
        $addressView->country_id = $syliusAddress->getCountryCode();
        $addressView->street = \explode(' ', $syliusAddress->getStreet());
        $addressView->postcode = $syliusAddress->getPostcode();
        $addressView->city = $syliusAddress->getCity();
        $addressView->firstname = $syliusAddress->getFirstName();
        $addressView->lastname = $syliusAddress->getLastName();
        $addressView->telephone = $syliusAddress->getPhoneNumber();

        return $addressView;
    }
}
