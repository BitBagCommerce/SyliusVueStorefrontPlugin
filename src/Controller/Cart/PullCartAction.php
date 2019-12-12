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
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\PullCartRequest;
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

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    public function __construct(
        RequestProcessorInterface $pullCartRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        OrderRepositoryInterface $orderRepository,
        CartItemViewFactoryInterface $cartItemViewFactory
    ) {
        $this->pullCartRequestProcessor = $pullCartRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->orderRepository = $orderRepository;
        $this->cartItemViewFactory = $cartItemViewFactory;
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

        /** @var PullCartRequest $pullCartRequest */
        $pullCartRequest = $this->pullCartRequestProcessor->getRequest($request);

        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy([
            'tokenValue' => $pullCartRequest->cartId,
            'state' => OrderInterface::STATE_CART,
        ]);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->cartItemViewFactory->createList($cart->getItems())
            ),
            Response::HTTP_OK
        ));
    }
}
