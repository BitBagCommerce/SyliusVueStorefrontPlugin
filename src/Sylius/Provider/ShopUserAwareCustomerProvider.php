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

use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ShopUserAwareCustomerProvider implements CustomerProviderInterface
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var FactoryInterface */
    private $customerFactory;

    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        LoggedInShopUserProviderInterface $loggedInShopUserProvider
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
    }

    public function provide(?string $cartId = null): CustomerInterface
    {
        if ($this->loggedInShopUserProvider->isUserLoggedIn()) {
            $loggedInUser = $this->loggedInShopUserProvider->provide();

            return $loggedInUser->getCustomer();
        }

        dump('niezalogowany');
        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();
        $customer->setEmail(sprintf('%s@guest.example', $cartId));
        $customer->setFirstName('Guest');
        $customer->setLastName('Customer');

        $this->customerRepository->add($customer);

        return $customer;
    }
}
