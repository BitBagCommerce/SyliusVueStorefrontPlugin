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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\ShippingInformationViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
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
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        RequestProcessorInterface $setShippingInformationRequestProcessor,
        MessageBusInterface $bus,
        OrderRepositoryInterface $orderRepository,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ShippingInformationViewFactoryInterface $shippingInformationViewFactory
    ) {
        $this->setShippingInformationRequestProcessor = $setShippingInformationRequestProcessor;
        $this->bus = $bus;
        $this->orderRepository = $orderRepository;
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

        /** @var SetShippingInformation $setShippingInformationCommand */
        $setShippingInformationCommand = $this->setShippingInformationRequestProcessor->getCommand($request);

        $this->bus->dispatch($setShippingInformationCommand);

        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $setShippingInformationCommand->cartId(), 'shippingState' => OrderInterface::STATE_CART]);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->shippingInformationViewFactory->create([], $cart)
            ),
            Response::HTTP_OK
        ));
    }
}
