<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class LoggedInShopUserProvider implements LoggedInShopUserProviderInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function provide(): ShopUserInterface
    {
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            throw new TokenNotFoundException('No token found');
        }

        /** @var ShopUserInterface|null $user */
        $user = $token->getUser();

        if (!$user instanceof ShopUserInterface) {
            throw new TokenNotFoundException('No logged in user');
        }

        return $user;
    }

    public function isUserLoggedIn(): bool
    {
        $token = $this->tokenStorage->getToken();

        return null !== $token && $token->getUser() instanceof ShopUserInterface;
    }
}
