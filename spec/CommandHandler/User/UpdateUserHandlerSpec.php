<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\UpdateUserHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\UserAddress;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier\DefaultAddressModifierInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;

final class UpdateUserHandlerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateUserHandler::class);
    }

    function let(
        CustomerRepositoryInterface $customerRepository,
        AddressRepositoryInterface $addressRepository,
        AddressFactoryInterface $addressFactory,
        ObjectManager $objectManager,
        DefaultAddressModifierInterface $defaultAddressModifier
    ): void {
        $this->beConstructedWith(
            $customerRepository,
            $addressRepository,
            $addressFactory,
            $objectManager,
            $defaultAddressModifier
        );
    }

    function it_updates_user(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer,
        AddressInterface $syliusAddress,
        AddressRepositoryInterface $addressRepository,
        ObjectManager $objectManager,
        ArrayCollection $collection,
        DefaultAddressModifierInterface $defaultAddressModifier
    ): void {
        $existingUser = new ExistingUser();
        $existingUser->email = 'shop@example.com';
        $existingUser->firstname = 'Janko';
        $existingUser->lastname = 'Banas';

        $region = new Address\Region();
        $region->region = 'example-region';

        $address = new UserAddress();
        $address->region_id = 'province-code';
        $address->region = $region;
        $address->company = 'example';
        $address->telephone = '987 654 321';
        $address->postcode = '12345';
        $address->country_id = 'PL';
        $address->street = ['example-street', '18'];
        $address->city = 'example-city';
        $address->firstname = 'Janko';
        $address->lastname = 'Banas';

        $existingUser->addresses = [$address];

        $command = new UpdateUser($existingUser);

        $customerRepository->findOneBy(['email' => 'shop@example.com'])->willReturn($customer);

        $customer->setFirstName('Janko')->shouldBeCalled();
        $customer->setLastName('Banas')->shouldBeCalled();

        $customer->getAddresses()->willReturn($collection);
        $collection->matching(Argument::any())->willreturn($collection);
        $collection->first()->willReturn($syliusAddress);

        $syliusAddress->setProvinceCode('province-code')->shouldBeCalled();
        $syliusAddress->setProvinceName('example-region')->shouldBeCalled();
        $syliusAddress->setCompany('example')->shouldBeCalled();
        $syliusAddress->setPhoneNumber('987 654 321')->shouldBeCalled();
        $syliusAddress->setPostcode('12345')->shouldBeCalled();
        $syliusAddress->setCountryCode('PL')->shouldBeCalled();
        $syliusAddress->setStreet('example-street 18')->shouldBeCalled();
        $syliusAddress->setCity('example-city')->shouldBeCalled();
        $syliusAddress->setFirstName('Janko')->shouldBeCalled();
        $syliusAddress->setLastName('Banas')->shouldBeCalled();

        $addressRepository->add($syliusAddress->getWrappedObject())->shouldBeCalled();

        $defaultAddressModifier->modify($customer, $syliusAddress->getWrappedObject())->shouldBeCalled();

        $objectManager->flush()->shouldBeCalledOnce();

        $this->__invoke($command);
    }
}
