<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ShopUserAwareCustomerProvider;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ShopUserAwareCustomerProviderSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ShopUserAwareCustomerProvider::class);
    }

    function let(
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        LoggedInShopUserProviderInterface $loggedInShopUserProvider
    ): void {
        $this->beConstructedWith(
            $customerRepository,
            $customerFactory,
            $loggedInShopUserProvider
        );
    }

    function it_provides_customer_for_logged_in_shop_user(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        ShopUserInterface $loggedInUser,
        CustomerInterface $customer
    ): void {
        $loggedInShopUserProvider->isUserLoggedIn()->willReturn(true);

        $loggedInShopUserProvider->provide()->willReturn($loggedInUser);
        $loggedInUser->getCustomer()->willReturn($customer);

        $this->provide()->shouldReturnAnInstanceOf(CustomerInterface::class);
    }

    function it_provides_customer_for_not_logged_in_shop_user(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        FactoryInterface $customerFactory,
        CustomerInterface $customer,
        CustomerRepositoryInterface $customerRepository
    ): void {
        $loggedInShopUserProvider->isUserLoggedIn()->willReturn(false);

        $customerFactory->createNew()->willReturn($customer);
        $customer->setEmail(sprintf('%s@guest.example', null))->shouldBeCalled();

        $customerRepository->add($customer)->shouldBeCalled();

        $this->provide()->shouldReturnAnInstanceOf(CustomerInterface::class);
    }
}
