<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\View\AddressView;
use Sylius\Component\Addressing\Model\AddressInterface as SyliusAddressInterface;

final class AddressViewFactory implements AddressViewFactoryInterface
{
    public function create(SyliusAddressInterface $syliusAddress): AddressView
    {
        $addressView = new AddressView();
        $addressView->id = $syliusAddress->getId();
        $addressView->customer_id = $syliusAddress->getCustomer()->getId();
        $addressView->country_id = $syliusAddress->getCountryCode();
        // todo: street array vs string in Sylius
        $addressView->street = $syliusAddress->getStreet();
        $addressView->postcode = $syliusAddress->getPostcode();
        $addressView->city = $syliusAddress->getCity();
        $addressView->firstname = $syliusAddress->getFirstName();
        $addressView->lastname = $syliusAddress->getLastName();

        return $addressView;
    }
}
