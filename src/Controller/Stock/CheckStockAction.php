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
use BitBag\SyliusVueStorefrontPlugin\Query\Stock\CheckStock;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckStockAction
{
    /** @var RequestProcessorInterface */
    private $checkStockRequestProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var StockViewFactoryInterface */
    private $stockViewFactory;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    public function __construct(
        RequestProcessorInterface $checkStockRequestProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        StockViewFactoryInterface $stockViewFactory,
        ProductVariantRepositoryInterface $productVariantRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ) {
        $this->checkStockRequestProcessor = $checkStockRequestProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->stockViewFactory = $stockViewFactory;
        $this->productVariantRepository = $productVariantRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->checkStockRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var CheckStock $checkStockQuery */
        $checkStockQuery = $this->checkStockRequestProcessor->getQuery($request);

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantRepository->findOneBy(['code' => $checkStockQuery->sku()]);

        if (null === $productVariant) {
            return $this->viewHandler->handle(View::create(
                [], Response::HTTP_NOT_FOUND
            ));
        }

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->stockViewFactory->create($productVariant)
            ),
            Response::HTTP_OK
        ));
    }
}
