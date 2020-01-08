<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Stock;

use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\Stock\StockViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\Stock\ListStocks;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListStocksAction
{
    /** @var RequestProcessorInterface */
    private $listStocksRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var StockViewFactoryInterface */
    private $stockViewFactory;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    public function __construct(
        RequestProcessorInterface $listStocksRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        StockViewFactoryInterface $stockViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->listStocksRequestProcessor = $listStocksRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->stockViewFactory = $stockViewFactory;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->listStocksRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var ListStocks $listStocksQuery */
        $listStocksQuery = $this->listStocksRequestProcessor->getQuery($request);

        $productsVariantsCodes = $listStocksQuery->SKUsToArray();

        $productsVariants = $this->productVariantRepository->findby(['code' => $productsVariantsCodes]);

        if (null === $productsVariantsCodes) {
            return $this->viewHandler->handle(View::create(
                [], Response::HTTP_NOT_FOUND
            ));
        }

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->stockViewFactory->createList(...$productsVariants)
            ),
            Response::HTTP_OK
        ));
    }
}
