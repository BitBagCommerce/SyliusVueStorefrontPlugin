<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\OrderAddressInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

interface AddressProviderInterface
{
    public function provide(CustomerInterface $customer, OrderAddressInterface $receivedAddress, bool $useDefaultSyliusAddressIfSpecified = false): AddressInterface;
}
