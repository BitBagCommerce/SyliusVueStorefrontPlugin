<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Handler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\ApplyCoupon;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PromotionCouponInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Promotion\Repository\PromotionCouponRepositoryInterface;
use Webmozart\Assert\Assert;

final class ApplyCouponHandler
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var PromotionCouponRepositoryInterface */
    private $couponRepository;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var PromotionCouponEligibilityCheckerInterface */
    private $couponEligibilityChecker;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        PromotionCouponRepositoryInterface $couponRepository,
        OrderProcessorInterface $orderProcessor,
        PromotionCouponEligibilityCheckerInterface $couponEligibilityChecker
    ) {
        $this->orderRepository = $orderRepository;
        $this->couponRepository = $couponRepository;
        $this->orderProcessor = $orderProcessor;
        $this->couponEligibilityChecker = $couponEligibilityChecker;
    }

    /** @param AddCoupon $addCoupon */
    public function __invoke(ApplyCoupon $applyCoupon): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $addCoupon->orderToken()]);

        Assert::notNull($cart, sprintf('Cart with token %s has not been found.', $addCoupon->orderToken()));

        /** @var PromotionCouponInterface $coupon */
        $coupon = $this->couponRepository->findOneBy(['code' => $addCoupon->couponCode()]);

        Assert::notNull($coupon, sprintf('Coupon with code %s has not been found.', $addCoupon->couponCode()));
        Assert::true($this->couponEligibilityChecker->isEligible($cart, $coupon));

        $cart->setPromotionCoupon($coupon);

        $this->orderProcessor->process($cart);
    }
}
