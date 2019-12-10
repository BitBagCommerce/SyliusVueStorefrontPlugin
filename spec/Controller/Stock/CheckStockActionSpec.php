<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Stock;

use BitBag\SyliusVueStorefrontPlugin\Controller\Stock\CheckStockAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\Stock\StockViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Stock\CheckStockRequest;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\Stock\StockView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CheckStockActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CheckStockAction::class);
    }

    function let(
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        StockViewFactoryInterface $stockViewFactory,
        ProductVariantRepositoryInterface $productVariantRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ): void {
        $this->beConstructedWith(
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $stockViewFactory,
            $productVariantRepository,
            $genericSuccessViewFactory
        );
    }

    function it_checks_stock_for_not_null_product_variant(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductVariantInterface $productVariant,
        StockViewFactoryInterface $stockViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [], [
            'sku' => 'example-sku',
        ]);

        $checkStockRequest = new CheckStockRequest($request);

        $validator->validate($checkStockRequest)->willReturn($violationList);

        $productVariantRepository->findOneBy(['code' => 'example-sku'])->willReturn($productVariant);

        $stockViewFactory->create($productVariant)->willReturn(new StockView());

        $genericSuccessViewFactory->create(Argument::any())->willReturn(new GenericSuccessView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }

    function it_checks_stock_for_null_product_variant(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        ProductVariantRepositoryInterface $productVariantRepository,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [], [
            'sku' => 'example-sku',
        ]);

        $checkStockRequest = new CheckStockRequest($request);

        $validator->validate($checkStockRequest)->willReturn($violationList);

        $productVariantRepository->findOneBy(['code' => 'example-sku'])->willReturn(null);

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }

    function it_returns_validation_error(
        ValidatorInterface $validator,
        ConstraintViolationInterface $constraintViolation,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [], [
            'sku' => 'example-sku',
        ]);

        $checkStockRequest = new CheckStockRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($checkStockRequest)->willReturn($violationList);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
