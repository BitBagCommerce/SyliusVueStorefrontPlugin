<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Addressing\Model\AddressInterface;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateUserHandler implements MessageHandlerInterface
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var AddressRepositoryInterface */
    private $addressRepository;

    /** @var AddressFactoryInterface */
    private $addressFactory;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        AddressRepositoryInterface $addressRepository,
        AddressFactoryInterface $addressFactory,
        ObjectManager $objectManager
    ) {
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
        $this->addressFactory = $addressFactory;
        $this->objectManager = $objectManager;
    }

    public function __invoke(UpdateUser $command): void
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy(['id' => $command->customer()->id]);

        $customer->setFirstName($command->customer()->firstname);
        $customer->setLastName($command->customer()->lastname);

        $addresses = $command->customer()->addresses();

        foreach ($addresses as $address) {
            /** @var AddressInterface $syliusAddress */
            $syliusAddress = $customer->getAddresses()
                ->matching(Criteria::create()
                    ->where(Criteria::expr()->eq('id', $address->id)))
                ->first()
            ;

            if (false === $syliusAddress) {
                $syliusAddress = $this->addressFactory->createForCustomer($customer);
            }

            $syliusAddress->setProvinceCode((string) $address->region_id);
            $syliusAddress->setProvinceName((string) $address->region()->region);
            $syliusAddress->setCompany($address->company);
            $syliusAddress->setPhoneNumber($address->telephone);
            $syliusAddress->setPostcode($address->postcode);
            $syliusAddress->setCountryCode($address->country_id);
            $syliusAddress->setStreet($address->street);
            $syliusAddress->setCity($address->city);
            $syliusAddress->setFirstName($address->firstname);
            $syliusAddress->setLastName($address->lastname);

            $this->addressRepository->add($syliusAddress);
        }

        $this->objectManager->flush();
    }
}
