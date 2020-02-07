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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Generator\UuidGeneratorInteface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Repository\OrderItemRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateCartAction
{
    /** @var RequestProcessorInterface */
    private $updateCartRequestProcessor;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var UuidGeneratorInteface */
    private $uuidGenerator;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    public function __construct(
        RequestProcessorInterface $updateCartRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        UuidGeneratorInteface $uuidGenerator,
        OrderItemRepositoryInterface $orderItemRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        CartItemViewFactoryInterface $cartItemViewFactory
    ) {
        $this->updateCartRequestProcessor = $updateCartRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->uuidGenerator = $uuidGenerator;
        $this->orderItemRepository = $orderItemRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->cartItemViewFactory = $cartItemViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->updateCartRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var UpdateCart $updateCartCommand */
        $updateCartCommand = $this->updateCartRequestProcessor->getCommand($request);
        $updateCartCommand->setOrderItemUuid($this->uuidGenerator->generate());

        $this->bus->dispatch($updateCartCommand);

        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemRepository->findOneBy([
            'uuid' => $updateCartCommand->getOrderItemUuid(),
        ]);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->cartItemViewFactory->createUpdateResponse($orderItem)),
            Response::HTTP_OK
        ));
    }
}
