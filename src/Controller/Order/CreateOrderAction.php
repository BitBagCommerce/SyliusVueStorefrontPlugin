<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Order;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @todo
 */
final class CreateOrderAction
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInUserProvider;

    public function __construct(LoggedInShopUserProviderInterface $loggedInUserProvider)
    {
        $this->loggedInUserProvider = $loggedInUserProvider;
    }

    public function __invoke(Request $request): Response
    {
    }
}
