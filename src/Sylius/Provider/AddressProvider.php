<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
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

    public function provide(CustomerInterface $customer, SetShippingInformation $command, bool $useDefaultSyliusAddressIfSpecified = false): AddressInterface
    {
        /** @var AddressInterface|null $address */
        $address = $this->addressRepository->findOneBy(['customer' => $customer->getId()]);

        if (null !== $address && true === $useDefaultSyliusAddressIfSpecified) {
            return $address;
        }

        $address = $this->addressFactory->createNew();

        $address->setCreatedAt(new \DateTime());

        $address->setStreet($command->addressInformation()->getShippingAddress()->getStreet());
        Assert::notNull(
            $command->addressInformation()->getShippingAddress()->getStreet(),
            sprintf('There is no default street for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setPostcode($command->addressInformation()->getShippingAddress()->getPostcode());
        Assert::notNull(
            $command->addressInformation()->getShippingAddress()->getPostcode(),
            sprintf('There is no default postcode for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setCity($command->addressInformation()->getShippingAddress()->getPostcode());
        Assert::notNull(
            $command->addressInformation()->getShippingAddress()->getCity(),
            sprintf('There is no default city for customer (id: %d). You have to provide it in request.', $customer->getId())
        );

        $address->setFirstName($customer->getFirstName());
        Assert::notNull($customer->getFirstName(), sprintf('Customer (id: %d) has not provided a valid first name.', $customer->getId()));

        $address->setLastName($customer->getLastName());
        Assert::notNull($customer->getLastName(), sprintf('Customer (id: %d) has not provided a valid last name.', $customer->getId()));

        $address->setCountryCode($command->addressInformation()->getShippingAddress()->getCountryId());

        return $address;
    }
}
