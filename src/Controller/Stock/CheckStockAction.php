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

use BitBag\SyliusVueStorefrontPlugin\Factory\Stock\CheckStockViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Stock\CheckStockProductRequest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductVariantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CheckStockAction
{
    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var CheckStockViewFactoryInterface */
    private $checkStockViewFactory;

    /** @var ProductVariantRepository */
    private $productVariant;

    public function __construct(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        CheckStockViewFactoryInterface $checkStockViewFactory,
        ProductVariantRepository $productVariant
    ) {
        $this->bus = $bus;
        $this->validator = $validator;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->checkStockViewFactory = $checkStockViewFactory;
        $this->productVariant = $productVariant;
    }

    public function __invoke(Request $request): Response
    {
        $checkStockProductRequest = CheckStockProductRequest::fromHttpRequest($request);

        $validationResults = $this->validator->validate($checkStockProductRequest);

        if (0 !== count($validationResults) ) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        $productVariant = $this->productVariant->findOneBy(['code' => $request->get('sku') ]);

        if (null == $productVariant) {
            return $this->viewHandler->handle(View::create(
                [], Response::HTTP_NOT_FOUND
            ));
        }
        return $this->viewHandler->handle(View::create(
            $this->checkStockViewFactory->create($productVariant),
            Response::HTTP_OK
        ));
    }
}
