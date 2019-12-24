<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

interface DefaultAddressModifierInterface
{
    public function modify(CustomerInterface $customer, AddressInterface $address): void;
}
