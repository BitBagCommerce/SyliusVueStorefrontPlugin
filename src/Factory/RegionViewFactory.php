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

use BitBag\SyliusVueStorefrontPlugin\View\RegionView;
use Sylius\Component\Addressing\Model\AddressInterface as SyliusAddressInterface;

final class RegionViewFactory implements RegionViewFactoryInterface
{
    public function create(SyliusAddressInterface $address): RegionView
    {
        $regionView = new RegionView();
        $regionView->regionCode = $address->getProvinceCode();
        $regionView->regionId = $address->getProvinceCode();
        $regionView->region = $address->getProvinceName();

        return $regionView;
    }
}
