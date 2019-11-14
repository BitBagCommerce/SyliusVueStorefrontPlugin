<?php

namespace BitBag\SyliusVueStorefrontPlugin\Response\User;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler as BaseAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;

/**
 * AuthenticationSuccessHandler.
 *
 * @author Dev Lexik <dev@lexik.fr>
 */
class AuthenticationSuccessHandler extends BaseAuthenticationSuccessHandler
{
    private const AUTHENTICATION_SUCCESS = 'bitbag_sylius_vue_storefront_plugin.lexik_jwt_authentication.handler.authentication_success';
    protected $jwtManager;

    protected $dispatcher;

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

        if ($this->dispatcher instanceof ContractsEventDispatcherInterface) {
            $this->dispatcher->dispatch($event, self::AUTHENTICATION_SUCCESS);
        } else {
            $this->dispatcher->dispatch(self::AUTHENTICATION_SUCCESS, $event);
        }

        $response->setData($event->getData());

        return $response;
    }
}
