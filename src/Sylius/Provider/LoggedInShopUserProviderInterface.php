<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Core\Model\ShopUserInterface;

interface LoggedInShopUserProviderInterface
{
    public function provide(): ShopUserInterface;

    public function isUserLoggedIn(): bool;
}
