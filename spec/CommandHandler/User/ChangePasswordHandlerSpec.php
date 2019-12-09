<?php

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
    public function let(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepositoryInterface $shopUserRepository
    ): void {
        $this->beConstructedWith($loggedInShopUserProvider, $userPasswordEncoder, $shopUserRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangePasswordHandler::class);
    }

    public function it_changes_password(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepositoryInterface $shopUserRepository,
        ShopUserInterface $shopUser
    ): void {
        $password = 'new-password';
        $encodedPassword = 'encoded-new-password';

        $changePassword = new ChangePassword($password);
        $loggedInShopUserProvider->provide()->willReturn($shopUser);

        $shopUser->setPlainPassword($password)->shouldBeCalledOnce();

        $userPasswordEncoder->encode($shopUser)->willReturn($encodedPassword);
        $shopUser->setPassword($encodedPassword)->shouldBeCalledOnce();

        $shopUserRepository->add($shopUser)->shouldBeCalledOnce();

        $this->__invoke($changePassword);
    }
}
