<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Api\Domain\CartService;
use BitBag\SyliusVueStorefrontPlugin\Response\VueStorefrontResponse;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateOrderAction
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInUserProvider;

    public function __construct(CartService $domain, LoggedInShopUserProviderInterface $loggedInUserProvider)
    {
        $this->domain = $domain;
        $this->loggedInUserProvider = $loggedInUserProvider;
    }

    public function __invoke(Request $request): Response
    {
        $this->loggedInUserProvider->isUserLoggedIn();

        if (null === $request) {
            return VueStorefrontResponse::error('Invalid request');
            //            throw new BadRequestHttpException();
        }

        $payload = $this->domain->createCart($request);

        return VueStorefrontResponse::success($payload);
    }
}
