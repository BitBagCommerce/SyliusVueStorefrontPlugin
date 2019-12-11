<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Response\User;

use BitBag\SyliusVueStorefrontPlugin\Response\User\AuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PhpSpec\ObjectBehavior;
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
