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
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class SetShippingMethodsAction
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

    /** @var ShippingMethodsViewFactoryInterface */
    private $shippingMethodsViewFactory;

    /** @var ShippingMethodRepositoryInterface */
    private $shippingMethodRepository;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ZoneMatcher */
    private $zoneMatcher;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    public function __construct(
        RequestProcessorInterface $setShippingInformationRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ShippingMethodsViewFactoryInterface $shippingMethodsViewFactory,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        OrderRepositoryInterface $orderRepository,
        ZoneMatcher $zoneMatcher,
        ChannelProviderInterface $channelProvider
    ) {
        $this->setShippingInformationRequestProcessor = $setShippingInformationRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->shippingMethodsViewFactory = $shippingMethodsViewFactory;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->orderRepository = $orderRepository;
        $this->zoneMatcher = $zoneMatcher;
        $this->channelProvider = $channelProvider;
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

        $query = $this->setShippingInformationRequestProcessor->getQuery($request);

        $channel = $this->channelProvider->provide();

        $zone = $this->zoneMatcher->match($query->address()->country_id, ZoneInterface::TYPE_COUNTRY);
        $shipment = $this->shippingMethodRepository->findEnabledForZonesAndChannel([$zone], $channel);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create($this->shippingMethodsViewFactory->createList(...$shipment)),
            Response::HTTP_OK
        ));
    }
}
