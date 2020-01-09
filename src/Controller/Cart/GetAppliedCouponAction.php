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

use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetAppliedCouponAction
{
    /** @var RequestProcessorInterface */
    private $getAppliedCouponProcessor;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    public function __construct(
        RequestProcessorInterface $getAppliedCouponProcessor,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        OrderRepositoryInterface $orderRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ) {
        $this->getAppliedCouponProcessor = $getAppliedCouponProcessor;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->orderRepository = $orderRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->getAppliedCouponProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        $code = $this->getAppliedCouponProcessor->getQuery($request);

        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $code->cartId(), 'state' => OrderInterface::STATE_CART]);

        $promotionCoupon = $cart->getPromotionCoupon() ?? false;

        if ($promotionCoupon) {
            $promotionCoupon = $promotionCoupon->getCode();
        }

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create($promotionCoupon)
        ));
    }
}
