<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\Cart\PullCart;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PullCartAction
{
    /** @var RequestProcessorInterface */
    private $pullCartRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        RequestProcessorInterface $pullCartRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        CartItemViewFactoryInterface $cartItemViewFactory,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->pullCartRequestProcessor = $pullCartRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->cartItemViewFactory = $cartItemViewFactory;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->pullCartRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var PullCart $pullCartRequest */
        $pullCartRequest = $this->pullCartRequestProcessor->getQuery($request);

        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(
            [
                'tokenValue' => $pullCartRequest->cartId(),
                'state' => OrderInterface::STATE_CART,
            ]
        );

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->cartItemViewFactory->createList($cart->getItems())
            ),
            Response::HTTP_OK
        ));
    }
}
