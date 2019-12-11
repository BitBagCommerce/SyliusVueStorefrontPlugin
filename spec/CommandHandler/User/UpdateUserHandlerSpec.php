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
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Addressing\Model\AddressInterface;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
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
        ObjectManager $objectManager
    ): void {
        $this->beConstructedWith(
            $customerRepository,
            $addressRepository,
            $addressFactory,
            $objectManager
        );
    }

    function it_updates_user(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer,
        AddressInterface $syliusAddress,
        AddressRepositoryInterface $addressRepository,
        ObjectManager $objectManager,
        ArrayCollection $collection
    ): void {
        $existingUser = ExistingUser::createFromArray([
            'id' => 1,
            'group_id' => 2,
            'default_billing' => 'example',
            'default_shipping' => 'example',
            'created_at' => 'now',
            'updated_at' => 'now',
            'created_in' => 'example',
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska',
            'store_id' => 3,
            'website_id' => 4,
            'addresses' => [
                1 => [
                    'id' => 1,
                    'customer_id' => 1,
                    'region' => [
                        'region_code' => 'example-code',
                        'region' => 'example-region',
                        'region_id' => 1,
                    ],
                    'region_id' => 1,
                    'country_id' => 'country',
                    'street' => 'example-street',
                    'company' => 'example',
                    'telephone' => '987 654 321',
                    'postcode' => '12345',
                    'city' => 'example-city',
                    'firstname' => 'Katarzyna',
                    'lastname' => 'Nosowska',
                    'vat_id' => 'example-id',
                ],
                2 => [
                    'id' => 1,
                    'customer_id' => 1,
                    'region' => [
                        'region_code' => 'example-code',
                        'region' => 'example-region',
                        'region_id' => 1,
                    ],
                    'region_id' => 1,
                    'country_id' => 'country',
                    'street' => 'example-street',
                    'company' => 'example',
                    'telephone' => '987 654 321',
                    'postcode' => '12345',
                    'city' => 'example-city',
                    'firstname' => 'Katarzyna',
                    'lastname' => 'Nosowska',
                    'vat_id' => 'example-id',
                ],
            ],
            'disable_auto_group_change' => 1,
        ]);

        $command = new UpdateUser($existingUser);

        $customerRepository->findOneBy(['id' => $command->customer()->id()])->willReturn($customer);

        $customer->setFirstName($existingUser->firstName())->shouldBeCalled();
        $customer->setLastName($existingUser->lastName())->shouldBeCalled();

        $customer->getAddresses()->willReturn($collection);
        $collection->matching(Argument::any())->willreturn($collection);
        $collection->first()->willReturn($syliusAddress);

        $syliusAddress->setProvinceCode('1')->shouldBeCalled();
        $syliusAddress->setProvinceName('example-region')->shouldBeCalled();
        $syliusAddress->setCompany('example')->shouldBeCalled();
        $syliusAddress->setPhoneNumber('987 654 321')->shouldBeCalled();
        $syliusAddress->setPostcode('12345')->shouldBeCalled();
        $syliusAddress->setCountryCode('country')->shouldBeCalled();
        $syliusAddress->setStreet('example-street')->shouldBeCalled();
        $syliusAddress->setCity('example-city')->shouldBeCalled();
        $syliusAddress->setFirstName('Katarzyna')->shouldBeCalled();
        $syliusAddress->setLastName('Nosowska')->shouldBeCalled();

        $addressRepository->add($syliusAddress->getWrappedObject())->shouldBeCalled();

        $objectManager->flush()->shouldBeCalledOnce();

        $this->__invoke($command);
    }
}
