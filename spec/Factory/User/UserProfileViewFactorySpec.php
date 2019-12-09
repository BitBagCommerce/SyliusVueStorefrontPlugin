<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\User;

use BitBag\SyliusVueStorefrontPlugin\Factory\AddressViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\AddressView;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;

final class UserProfileViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(UserProfileViewFactory::class);
    }

    function let(AddressViewFactoryInterface $addressViewFactory): void
    {
        $this->beConstructedWith($addressViewFactory);
    }

    function it_creates_user_profile_view(
        CustomerInterface $syliusCustomer,
        AddressViewFactoryInterface $addressViewFactory,
        AddressInterface $address
    ): void {
        $syliusCustomer->getId()->shouldBeCalled();
        $syliusCustomer->getDefaultAddress()->willReturn($address);
        $syliusCustomer->getCreatedAt()->willReturn(new \DateTime('yesterday'));
        $syliusCustomer->getUpdatedAt()->willReturn(new \DateTime('yesterday'));
        $syliusCustomer->getEmail()->shouldBeCalled();
        $syliusCustomer->getFirstName()->shouldBeCalled();
        $syliusCustomer->getLastName()->shouldBeCalled();
        $syliusCustomer->getAddresses()->willReturn(new ArrayCollection(
            [
                $address->getWrappedObject(),
            ]
        ));

        $addressViewFactory->create(Argument::any())->willReturn(new AddressView());

        $this->create($syliusCustomer);
    }
}
