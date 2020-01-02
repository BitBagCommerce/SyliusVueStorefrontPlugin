<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

final class DefaultAddressModifier implements DefaultAddressModifierInterface
{
    /** @var ObjectManager */
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function modify(CustomerInterface $customer, AddressInterface $address): void
    {
        $defaultAddress = $customer->getDefaultAddress();

        if (null === $defaultAddress) {
            $customer->setDefaultAddress($address);

            $this->entityManager->persist($customer);
            $this->entityManager->flush();
        }
    }
}
