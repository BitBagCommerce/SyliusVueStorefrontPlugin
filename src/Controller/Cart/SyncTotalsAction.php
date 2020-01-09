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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\Totals\TotalsViewFactory;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\Cart\SyncTotals;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SyncTotalsAction
{
    /** @var RequestProcessorInterface */
    private $syncTotalsRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var TotalsViewFactory */
    private $totalsViewFactory;

    public function __construct(
        RequestProcessorInterface $syncTotalsRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        OrderRepositoryInterface $orderRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        TotalsViewFactory $totalsViewFactory
    ) {
        $this->syncTotalsRequestProcessor = $syncTotalsRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->orderRepository = $orderRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->totalsViewFactory = $totalsViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->syncTotalsRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var SyncTotals $syncTotalsQuery */
        $syncTotalsQuery = $this->syncTotalsRequestProcessor->getQuery($request);

        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneBy(
            [
                'tokenValue' => $syncTotalsQuery->cartId(),
                'state' => OrderInterface::STATE_CART,
            ]
        );

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->totalsViewFactory->create($order)
            ),
            Response::HTTP_OK
        ));
    }
}
