<?php

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
