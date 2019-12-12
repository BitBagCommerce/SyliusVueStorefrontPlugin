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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\ShippingInformationViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class SetShippingInformationAction
{
    /** @var RequestProcessorInterface */
    private $setShippingInformationRequestProcessor;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var ShippingInformationViewFactoryInterface */
    private $shippingInformationViewFactory;

    public function __construct(
        RequestProcessorInterface $setShippingInformationRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ShippingInformationViewFactoryInterface $shippingInformationViewFactory
    ) {
        $this->setShippingInformationRequestProcessor = $setShippingInformationRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->shippingInformationViewFactory = $shippingInformationViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->setShippingInformationRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->shippingInformationViewFactory->create()
            ),
            Response::HTTP_OK
        ));
    }
}
