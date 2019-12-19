<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

interface AddressProviderInterface
{
    public function provide(CustomerInterface $customer, SetShippingInformation $command, bool $useDefaultSyliusAddressIfSpecified = false): AddressInterface;
}
