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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Address\Addresses;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Sylius\Component\Addressing\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateUserHandler implements MessageHandlerInterface
{
    private const ADDRESS_ID = 'id';
    private const CUSTOMER_ID = 'id';

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var AddressRepositoryInterface */
    private $addressRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        AddressRepositoryInterface $addressRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
    }

    public function __invoke(UpdateUser $command): void
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy([self::CUSTOMER_ID => $command->customer()->Id()]);
        $customer->setFirstName($command->customer()->FirstName());
        $customer->setLastName($command->customer()->LastName());

        $arrayAddressFromClient = $command->customer()->Addresses();

        foreach ($arrayAddressFromClient as $propertyAddress) {
            $address = Addresses::createFromArray($propertyAddress);

            /** @var AddressInterface $findByOneAddressByd */
            $findByOneAddressByd = $customer->getAddresses()->matching(
                (new Criteria())
                    ->where(new Comparison(self::ADDRESS_ID, '=', $address->Id()))
            )->first();

            if (false !== $findByOneAddressByd) {
                $findByOneAddressByd->setProvinceCode((string) $address->regionId());
                $findByOneAddressByd->setProvinceName((string) $address->region()->region());
                $findByOneAddressByd->setCompany($address->company());
                $findByOneAddressByd->setPhoneNumber($address->telephone());
                $findByOneAddressByd->setPostcode($address->postcode());
                $findByOneAddressByd->setCountryCode($address->countryId());
                $findByOneAddressByd->setStreet($address->street());
                $findByOneAddressByd->setCity($address->city());
                $findByOneAddressByd->setFirstName($address->firstName());
                $findByOneAddressByd->setLastName($address->lastName());

                $this->addressRepository->add($findByOneAddressByd);
            }
        }
        $this->customerRepository->add($customer);
    }
}
