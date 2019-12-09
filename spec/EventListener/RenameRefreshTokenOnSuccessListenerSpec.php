<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\EventListener;

use BitBag\SyliusVueStorefrontPlugin\EventListener\RenameRefreshTokenOnSuccessListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

final class RenameRefreshTokenOnSuccessListenerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenameRefreshTokenOnSuccessListener::class);
    }

    function let(RequestStack $requestStack): void
    {
        $this->beConstructedWith($requestStack);
    }

    function it_renames_refresh_token_on_success(
        RequestStack $requestStack,
        UserInterface $user
    ): void {
        $request = new Request(
            [
                'refreshToken' => 'token'
            ],
            [],
            [],
            [],
            [],
            [
                'REQUEST_URI' => '/vsbridge/user/refresh',
            ]
        );

        /** @var AuthenticationSuccessEvent $event */
        $event = new AuthenticationSuccessEvent(['token' => 'token1', 'refreshToken' => 'token2'], $user->getWrappedObject(), new Response());
        $requestStack->getCurrentRequest()->willReturn($request);

        $this->renameRefreshToken($event);
    }
}
