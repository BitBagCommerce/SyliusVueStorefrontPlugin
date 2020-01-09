<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

final class DefaultAddressModifier implements DefaultAddressModifierInterface
{
    public function modify(CustomerInterface $customer, AddressInterface $address): void
    {
        $defaultAddress = $customer->getDefaultAddress();

        if (null === $defaultAddress) {
            $customer->setDefaultAddress($address);
        }
    }
}
