<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\EventListener;

use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AttachRefreshTokenOnAuthenticationSuccessListener
{
    private const ROUTE_LOGIN = '/vsbridge/user/login';

    /** @var RefreshTokenManagerInterface */
    protected $refreshTokenManager;

    /** @var int */
    protected $ttl;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var RequestStack */
    protected $requestStack;

    /** @var string */
    protected $userIdentityField;

    public function __construct(
        RefreshTokenManagerInterface $refreshTokenManager,
        int $ttl,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        string $userIdentityField
    ) {
        $this->refreshTokenManager = $refreshTokenManager;
        $this->ttl = $ttl;
        $this->validator = $validator;
        $this->requestStack = $requestStack;
        $this->userIdentityField = $userIdentityField;
    }

    public function attachRefreshToken(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();
        $request = $this->requestStack->getCurrentRequest();

        if (!$user instanceof UserInterface || self::ROUTE_LOGIN !== $request->getPathInfo()) {
            return;
        }

        $datetime = new \DateTime();
        $datetime->modify('+' . $this->ttl . ' seconds');

        $refreshToken = $this->refreshTokenManager->create();

        $accessor = new PropertyAccessor();
        $userIdentityFieldValue = $accessor->getValue($user, $this->userIdentityField);

        $refreshToken->setUsername($userIdentityFieldValue);
        $refreshToken->setRefreshToken();
        $refreshToken->setValid($datetime);

        $valid = false;
        while (false === $valid) {
            $valid = true;
            $errors = $this->validator->validate($refreshToken);
            if ($errors->count() > 0) {
                foreach ($errors as $error) {
                    if ('refreshToken' === $error->getPropertyPath()) {
                        $valid = false;
                        $refreshToken->setRefreshToken();
                    }
                }
            }
        }

        $this->refreshTokenManager->save($refreshToken);
        $data['meta']['refreshToken'] = $refreshToken->getRefreshToken();

        $event->setData($data);
    }
}
