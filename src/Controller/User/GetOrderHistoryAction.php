<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistoryViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOrderHistoryAction
{
    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var OrderHistoryViewFactoryInterface */
    private $orderHistoryViewFactory;

    public function __construct(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        ViewHandlerInterface $viewHandler,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        OrderHistoryViewFactoryInterface $orderHistoryViewFactory
    ) {
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
        $this->viewHandler = $viewHandler;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->orderHistoryViewFactory = $orderHistoryViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $user = $this->loggedInShopUserProvider->provide()->getCustomer();

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->orderHistoryViewFactory->create($user)),
            Response::HTTP_OK
        ));
    }
}
