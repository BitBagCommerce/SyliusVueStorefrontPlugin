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

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\ChangePasswordHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\UserPasswordEncoderInterface;

final class ChangePasswordHandlerSpec extends ObjectBehavior
{
    function let(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepositoryInterface $shopUserRepository
    ): void {
        $this->beConstructedWith($loggedInShopUserProvider, $userPasswordEncoder, $shopUserRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangePasswordHandler::class);
    }

    function it_changes_password(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepositoryInterface $shopUserRepository,
        ShopUserInterface $shopUser
    ): void {
        $changePassword = new ChangePassword('new-password');

        $loggedInShopUserProvider->provide()->willReturn($shopUser);

        $shopUser->setPlainPassword('new-password')->shouldBeCalledOnce();

        $userPasswordEncoder->encode($shopUser)->willReturn('encoded-new-password');

        $shopUser->setPassword('encoded-new-password')->shouldBeCalledOnce();

        $shopUserRepository->add($shopUser)->shouldBeCalledOnce();

        $this->__invoke($changePassword);
    }
}
