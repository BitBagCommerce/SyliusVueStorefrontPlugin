<?php

/*
 * This file is part of the GesdinetJWTRefreshTokenBundle package.
 *
 * (c) Gesdinet <http://www.gesdinet.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitBag\SyliusVueStorefrontPlugin\EventListener;

use Gesdinet\JWTRefreshTokenBundle\Event\RefreshEvent;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class RenameRefreshTokenOnSuccessListener
{
    /** @var RequestStack */
    protected $requestStack;

    public function __construct(
        RequestStack $requestStack
    ) {
        $this->requestStack = $requestStack;
    }

    public function renameRefreshToken(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();
        $request = $this->requestStack->getCurrentRequest();

        if (!$user instanceof UserInterface) {
            return;
        }

        if ('/vsbridge/user/refresh' === $request->getPathInfo()) {
            $data['result'] = $data['token'];
            unset($data['token']);
            unset($data['refreshToken']);

            $event->setData($data);
        }
    }
}
