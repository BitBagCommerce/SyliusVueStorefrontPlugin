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
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Webmozart\Assert\Assert;

final class AddressProvider implements AddressProviderInterface
{
    /** @var AddressRepositoryInterface */
    private $addressRepository;

    /** @var AddressFactoryInterface */
    private $addressFactory;

    public function __construct(AddressRepositoryInterface $addressRepository, AddressFactoryInterface $addressFactory)
    {
        $this->addressRepository = $addressRepository;
        $this->addressFactory = $addressFactory;
    }

    public function provide(CustomerInterface $customer, OrderAddressInterface $receivedAddress, bool $useDefaultSyliusAddressIfSpecified = false): AddressInterface
    {
        /** @var AddressInterface|null $address */
        $address = $this->addressRepository->findOneBy(['customer' => $customer->getId()]);

        if (null !== $address && true === $useDefaultSyliusAddressIfSpecified) {
            return $address;
        }

        $address = $this->addressFactory->createNew();

        $address->setCreatedAt(new \DateTime());

        $address->setStreet($receivedAddress->getStreet());
        Assert::notNull(
            $receivedAddress->getStreet(),
            sprintf('There is no default street for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setPostcode($receivedAddress->getPostcode());
        Assert::notNull(
            $receivedAddress->getPostcode(),
            sprintf('There is no default postcode for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setCity($receivedAddress->getPostcode());
        Assert::notNull(
            $receivedAddress->getCity(),
            sprintf('There is no default city for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setFirstName($customer->getFirstName());
        Assert::notNull($customer->getFirstName(), sprintf('Customer (id: %d) has not provided a valid first name.', $customer->getId()));

        $address->setLastName($customer->getLastName());
        Assert::notNull($customer->getLastName(), sprintf('Customer (id: %d) has not provided a valid last name.', $customer->getId()));

        $address->setCountryCode($receivedAddress->getCountryId());

        return $address;
    }
}
