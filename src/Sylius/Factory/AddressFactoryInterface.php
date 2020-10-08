<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Factory;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;
use Sylius\Component\Core\Factory\AddressFactoryInterface as BaseAddressFactoryInterface;
use Sylius\Component\Core\Model\AddressInterface;

interface AddressFactoryInterface extends BaseAddressFactoryInterface
{
    public function createFromDTO(Address $addressDTO): AddressInterface;

    public function fillAddressData(AddressInterface $address, Address $addressDTO): AddressInterface;
}
