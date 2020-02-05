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
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\User\GetOrderHistory;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOrderHistoryAction
{
    /** @var RequestProcessorInterface */
    private $getOrderHistoryRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var LoggedInShopUserProviderInterface */
    private $loggedInShopUserProvider;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var OrderHistoryViewFactoryInterface */
    private $orderHistoryViewFactory;

    public function __construct(
        RequestProcessorInterface $getOrderHistoryRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        OrderHistoryViewFactoryInterface $orderHistoryViewFactory
    ) {
        $this->getOrderHistoryRequestProcessor = $getOrderHistoryRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->loggedInShopUserProvider = $loggedInShopUserProvider;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->orderHistoryViewFactory = $orderHistoryViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->getOrderHistoryRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(
                View::create(
                    $this->validationErrorViewFactory->create($validationResults),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        $user = $this->loggedInShopUserProvider->provide()->getCustomer();

        /** @var GetOrderHistory $query */
        $query = $this->getOrderHistoryRequestProcessor->getQuery($request);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->orderHistoryViewFactory->create($user, $query->paginationParameters())),
            Response::HTTP_OK
        ));
    }
}
