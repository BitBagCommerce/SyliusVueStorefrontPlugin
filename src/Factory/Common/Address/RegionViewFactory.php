<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Common\Address;

use BitBag\SyliusVueStorefrontPlugin\View\Common\Address\RegionView;
use Sylius\Component\Addressing\Model\AddressInterface as SyliusAddressInterface;

final class RegionViewFactory implements RegionViewFactoryInterface
{
    /** @var string */
    private $regionViewClass;

    public function __construct(string $regionViewClass)
    {
        $this->regionViewClass = $regionViewClass;
    }

    public function create(SyliusAddressInterface $syliusAddress): RegionView
    {
        /** @var RegionView $regionView */
        $regionView = new $this->regionViewClass();
        $regionView->regionCode = $syliusAddress->getProvinceCode();
        $regionView->regionId = $syliusAddress->getProvinceCode();
        $regionView->region = $syliusAddress->getProvinceName();

        return $regionView;
    }
}
