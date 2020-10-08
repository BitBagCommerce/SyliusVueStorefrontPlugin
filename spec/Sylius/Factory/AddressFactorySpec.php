<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Factory;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\UserAddress;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\AddressFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\AddressInterface;

class AddressFactorySpec extends ObjectBehavior
{
    function let(AddressFactoryInterface $decoratedFactory): void
    {
        $this->beConstructedWith($decoratedFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AddressFactory::class);
    }

    function it_creates_address_from_dto(
        AddressFactoryInterface $decoratedFactory,
        AddressInterface $address,
        UserAddress $requestAddress
    ): void {
        $requestAddress->getStreet()->shouldBeCalled();
        $requestAddress->getPostcode()->shouldBeCalled();
        $requestAddress->getCity()->shouldBeCalled();
        $requestAddress->getFirstName()->shouldBeCalled();
        $requestAddress->getLastName()->shouldBeCalled();
        $requestAddress->getCountryId()->shouldBeCalled();
        $requestAddress->getRegionId()->shouldBeCalled();
        $requestAddress->region()->shouldBeCalled();

        $decoratedFactory->createNew()->willReturn($address);

        $address->setCreatedAt(Argument::type(\DateTime::class))->shouldBeCalled();
        $address->setStreet(Argument::type('string'))->shouldBeCalled();
        $address->setPostcode(Argument::type('string'))->shouldBeCalled();
        $address->setCity(Argument::type('string'))->shouldBeCalled();
        $address->setFirstName(Argument::type('string'))->shouldBeCalled();
        $address->setLastName(Argument::type('string'))->shouldBeCalled();
        $address->setCountryCode(Argument::type('string'))->shouldBeCalled();
        $address->setProvinceCode(Argument::type('string'))->shouldBeCalled();
        $address->setProvinceName(Argument::type('string'))->shouldBeCalled();

        $this->createFromDTO($requestAddress)->shouldReturnAnInstanceOf(AddressInterface::class);
    }
}
