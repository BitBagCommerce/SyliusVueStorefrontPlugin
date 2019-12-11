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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProvider;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class LoggedInShopUserProviderSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(LoggedInShopUserProvider::class);
    }

    function let(TokenStorageInterface $tokenStorage): void
    {
        $this->beConstructedWith($tokenStorage);
    }

    function it_provides_logged_in_shop_user(
        TokenStorageInterface $tokenStorage,
        TokenInterface $token,
        ShopUserInterface $user
    ): void {
        $token->setAttribute('attribute', 'value');
        $tokenStorage->getToken()->willReturn($token);
        $token->getUser()->willReturn($user);

        $this->provide()->shouldReturnAnInstanceOf(ShopUserInterface::class);
    }

    function it_handles_no_token_situation(TokenStorageInterface $tokenStorage): void
    {
        $tokenStorage->getToken()->willReturn(null);

        $this
            ->shouldThrow(TokenNotFoundException::class)
            ->during('provide');
    }

    function it_handles_no_user_situation(
        TokenStorageInterface $tokenStorage,
        TokenInterface $token
    ): void {
        $tokenStorage->getToken()->willReturn($token);

        $this
            ->shouldThrow(TokenNotFoundException::class)
            ->during('provide');
    }
}
