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

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\UserPasswordEncoderInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ChangePasswordHandler implements MessageHandlerInterface
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    /** @var UserPasswordEncoderInterface */
    private $userPasswordEncoder;

    /** @var UserRepositoryInterface */
    private $shopUserRepository;

    public function __construct(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepositoryInterface $shopUserRepository
    ) {
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->shopUserRepository = $shopUserRepository;
    }

    public function __invoke(ChangePassword $changePassword): void
    {
        $shopUser = $this->loggedInShopUserProvider->provide();
        $shopUser->setPlainPassword($changePassword->newPassword());

        $encodedPassword = $this->userPasswordEncoder->encode($shopUser);

        $shopUser->setPassword($encodedPassword);

        $this->shopUserRepository->add($shopUser);
    }
}
