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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
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

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var ShippingInformationViewFactoryInterface */
    private $shippingInformationViewFactory;

    public function __construct(
        RequestProcessorInterface $setShippingInformationRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        OrderRepositoryInterface $orderRepository,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        ChannelProviderInterface $channelProvider,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ShippingInformationViewFactoryInterface $shippingInformationViewFactory
    ) {
        $this->setShippingInformationRequestProcessor = $setShippingInformationRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->orderRepository = $orderRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->channelProvider = $channelProvider;
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
        $cart = $this->orderRepository->findOneBy([
            'tokenValue' => $setShippingInformationCommand->cartId(),
            'shippingState' => OrderInterface::STATE_CART,
        ]);

        /** @var ChannelInterface $channel */
        $channel = $this->channelProvider->provide();

        /** @var PaymentMethodInterface[] $paymentMethods */
        $paymentMethods = $this->paymentMethodRepository->findEnabledForChannel($channel);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->shippingInformationViewFactory->create($paymentMethods, $cart)
            ),
            Response::HTTP_OK
        ));
    }
}
