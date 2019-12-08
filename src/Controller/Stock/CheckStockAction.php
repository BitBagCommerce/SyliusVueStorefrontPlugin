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
use BitBag\SyliusVueStorefrontPlugin\Request\Stock\CheckStockRequest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CheckStockAction
{
    /** @var ValidatorInterface */
    private $validator;

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
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        StockViewFactoryInterface $stockViewFactory,
        ProductVariantRepositoryInterface $productVariantRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ) {
        $this->validator = $validator;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->stockViewFactory = $stockViewFactory;
        $this->productVariantRepository = $productVariantRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $checkStockRequest = CheckStockRequest::fromHttpRequest($request);

        $validationResults = $this->validator->validate($checkStockRequest);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantRepository->findOneBy(['code' => $checkStockRequest->getSku()]);

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
