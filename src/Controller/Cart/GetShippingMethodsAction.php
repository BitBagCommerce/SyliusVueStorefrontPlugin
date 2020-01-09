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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\ShippingMethodsViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Matcher\ZoneMatcher;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Addressing\Model\ZoneInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Registry\ServiceRegistry;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetShippingMethodsAction
{
    /** @var RequestProcessorInterface */
    private $getShippingMethodsRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var ZoneMatcher */
    private $zoneMatcher;

    /** @var ShippingMethodRepositoryInterface */
    private $shippingMethodRepository;

    /** @var ServiceRegistry */
    private $serviceRegistry;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var ShippingMethodsViewFactoryInterface */
    private $shippingMethodsViewFactory;

    public function __construct(
        RequestProcessorInterface $getShippingMethodsRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        OrderRepositoryInterface $orderRepository,
        ChannelProviderInterface $channelProvider,
        ZoneMatcher $zoneMatcher,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        ServiceRegistry $serviceRegistry,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ShippingMethodsViewFactoryInterface $shippingMethodsViewFactory
    ) {
        $this->getShippingMethodsRequestProcessor = $getShippingMethodsRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->orderRepository = $orderRepository;
        $this->channelProvider = $channelProvider;
        $this->zoneMatcher = $zoneMatcher;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->serviceRegistry = $serviceRegistry;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->shippingMethodsViewFactory = $shippingMethodsViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->getShippingMethodsRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(
                View::create(
                    $this->validationErrorViewFactory->create($validationResults),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        $query = $this->getShippingMethodsRequestProcessor->getQuery($request);

        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(
            [
                'tokenValue' => $query->cartId(),
                'shippingState' => OrderInterface::STATE_CART,
            ]
        );

        $channel = $this->channelProvider->provide();

        $zone = $this->zoneMatcher->match($query->address()->country_id, ZoneInterface::TYPE_COUNTRY);

        /** @var ShippingMethodInterface[] $shipmentMethods */
        $shipmentMethods = $this->shippingMethodRepository->findEnabledForZonesAndChannel([$zone], $channel);

        foreach ($shipmentMethods as $shipmentMethod) {
            if (!$cart->getShipments()->first()) {
                continue;
            }

            /** @var CalculatorInterface $calculator */
            $calculator = $this->serviceRegistry->get($shipmentMethod->getCalculator());
            $calculator->calculate($cart->getShipments()->first(), $shipmentMethod->getConfiguration());
        }

        return $this->viewHandler->handle(
            View::create(
                $this->genericSuccessViewFactory->create(
                    $this->shippingMethodsViewFactory->createList(...$shipmentMethods)
                ),
                Response::HTTP_OK
            )
        );
    }
}
