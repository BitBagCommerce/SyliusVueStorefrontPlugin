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
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetPaymentMethodsAction
{
    /** @var RequestProcessorInterface */
    private $getPaymentMethodsRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var PaymentMethodViewFactoryInterface */
    private $paymentMethodViewFactory;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    public function __construct(
        RequestProcessorInterface $getPaymentMethodsRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        PaymentMethodViewFactoryInterface $paymentMethodViewFactory,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        ChannelProviderInterface $channelProvider
    ) {
        $this->getPaymentMethodsRequestProcessor = $getPaymentMethodsRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->paymentMethodViewFactory = $paymentMethodViewFactory;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->channelProvider = $channelProvider;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->getPaymentMethodsRequestProcessor->validate($request);

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
