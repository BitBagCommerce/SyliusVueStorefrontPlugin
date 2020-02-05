<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Authentication;

use BitBag\SyliusVueStorefrontPlugin\Authentication\AuthenticationFailureHandler;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class AuthenticationFailureHandlerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AuthenticationFailureHandler::class);
    }

    function it_handles_authentication_failure(Request $request, AuthenticationException $exception): void
    {
        $exception->getMessageKey()->willReturn('User not found.');

        $this->onAuthenticationFailure($request, $exception)->shouldReturnAnInstanceOf(JsonResponse::class);
    }
}
