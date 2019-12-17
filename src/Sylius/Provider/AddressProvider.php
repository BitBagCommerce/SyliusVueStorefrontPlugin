<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use Sylius\Component\Core\Model\Address;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Webmozart\Assert\Assert;

final class AddressProvider implements AddressProviderInterface
{
    /** @var AddressRepositoryInterface */
    private $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function provide(CustomerInterface $customer, SetShippingInformation $command): AddressInterface
    {
        /** @var AddressInterface|null $address */
        $address = $this->addressRepository->findOneBy(['customer' => $customer->getId()]);

        if (null !== $address) {
            return $address;
        }

        $address = new Address();

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

        $address->setCreatedAt(new \DateTime());

        $address->setFirstName($customer->getFirstName());
        Assert::notNull($customer->getFirstName(), sprintf('Customer (id: %d) has not provided a valid first name.', $customer->getId()));

        $address->setLastName($customer->getLastName());
        Assert::notNull($customer->getLastName(), sprintf('Customer (id: %d) has not provided a valid last name.', $customer->getId()));

        $address->setCountryCode($command->addressInformation()->getShippingAddress()->getCountryId());

        return $address;
    }
}
