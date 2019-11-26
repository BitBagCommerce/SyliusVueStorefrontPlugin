<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ChangePasswordHandler implements MessageHandlerInterface
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LoggedInShopUserProviderInterface $loggedInShopUserProvider
    ) {
        $this->customerRepository = $customerRepository;
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
    }

    public function __invoke(ChangePassword $changePassword): void
    {
        $customer = $this->loggedInShopUserProvider->provide();
        $customer->setPlainPassword($changePassword->getNewPassword());

        $this->customerRepository->add($customer);
    }
}
