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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartPaymentMethodsViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetPaymentMethodsRequest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GetPaymentMethodsAction
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var CartPaymentMethodsViewFactoryInterface */
    private $cartPaymentMethodsViewFactory;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        CartPaymentMethodsViewFactoryInterface $cartPaymentMethodsViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->validator = $validator;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->cartPaymentMethodsViewFactory = $cartPaymentMethodsViewFactory;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(Request $request): Response
    {
        $paymentMethodsRequest = GetPaymentMethodsRequest::fromHttpRequest($request);

        $validationResults = $this->validator->validate($paymentMethodsRequest);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        $cart = $this->orderRepository->findOneBy([
            'tokenValue' => $paymentMethodsRequest->getCartId(),
             'state' => OrderInterface::STATE_CART,
        ]);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->cartPaymentMethodsViewFactory->createList($cart->getPayments())
            )
        ));
    }
}
