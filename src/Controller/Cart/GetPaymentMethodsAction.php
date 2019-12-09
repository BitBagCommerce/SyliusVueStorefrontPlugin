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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\PaymentMethodViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetPaymentMethodsRequest;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
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

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    /** @var PaymentMethodViewFactoryInterface */
    private $paymentMethodViewFactory;

    public function __construct(
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ChannelProviderInterface $channelProvider,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        PaymentMethodViewFactoryInterface $paymentMethodViewFactory
    ) {
        $this->validator = $validator;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->channelProvider = $channelProvider;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentMethodViewFactory = $paymentMethodViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $getPaymentMethodsRequest = GetPaymentMethodsRequest::fromHttpRequest($request);

        $validationResults = $this->validator->validate($getPaymentMethodsRequest);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        $channel = $this->channelProvider->provide();

        $paymentMethods = $this->paymentMethodRepository->findEnabledForChannel($channel);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->paymentMethodViewFactory->createList($paymentMethods)
            )
        ));
    }
}
