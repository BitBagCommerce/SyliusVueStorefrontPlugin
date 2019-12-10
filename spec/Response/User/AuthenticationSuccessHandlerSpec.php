<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Response\User;

use BitBag\SyliusVueStorefrontPlugin\Response\User\AuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthenticationSuccessHandlerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AuthenticationSuccessHandler::class);
    }

    function let(JWTTokenManagerInterface $jwtManager, EventDispatcherInterface $dispatcher): void
    {
        $this->beConstructedWith($jwtManager, $dispatcher);
    }

    function it_handles_authentication_success(
        UserInterface $user,
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher
    ): void {
        $jwtManager->create($user)->shouldBeCalled();

        $dispatcher->dispatch(new AuthenticationSuccessEvent(
            [
                'result' => 'token',
                'code' => Response::HTTP_OK,
            ],
            $user->getWrappedObject(),
            new JWTAuthenticationSuccessResponse('token')
        ));

        $this->handleAuthenticationSuccess($user)->shouldReturnAnInstanceOf(JWTAuthenticationSuccessResponse::class);
    }
}
