<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler as BaseAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthenticationSuccessHandler extends BaseAuthenticationSuccessHandler
{
    public function handleAuthenticationSuccess(UserInterface $user, $jwt = null): JWTAuthenticationSuccessResponse
    {
        if (null === $jwt) {
            $jwt = $this->jwtManager->create($user);
        }

        $response = new JWTAuthenticationSuccessResponse($jwt);

        $event = new AuthenticationSuccessEvent(
            [
                'result' => $jwt,
                'code' => Response::HTTP_OK,
            ],
            $user,
            $response
        );

        $this->dispatcher->dispatch($event);

        return $response->setData($event->getData());
    }
}
