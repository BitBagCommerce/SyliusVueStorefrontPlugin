<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Cart;

use BitBag\SyliusVueStorefrontPlugin\Request\Cart\ApplyCouponRequest;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionCouponInterface;
use Sylius\Component\Promotion\Repository\PromotionCouponRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class ValidCouponValidator extends ConstraintValidator
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var PromotionCouponRepositoryInterface */
    private $couponRepository;

    /** @var PromotionCouponEligibilityCheckerInterface */
    private $couponEligibilityChecker;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        PromotionCouponRepositoryInterface $couponRepository,
        PromotionCouponEligibilityCheckerInterface $couponEligibilityChecker
    ) {
        $this->orderRepository = $orderRepository;
        $this->couponRepository = $couponRepository;
        $this->couponEligibilityChecker = $couponEligibilityChecker;
    }

    public function validate($request, Constraint $constraint): void
    {
        Assert::isInstanceOf($request, ApplyCouponRequest::class);

        /** @var OrderInterface|null $cart */
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $request->cartId, 'state' => OrderInterface::STATE_CART]);

        if (null === $cart) {
            return;
        }

        /** @var PromotionCouponInterface|null $coupon */
        $coupon = $this->couponRepository->findOneBy(['code' => $request->coupon]);

        if (null === $coupon || !$this->couponEligibilityChecker->isEligible($cart, $coupon)) {
            $this->context->addViolation($constraint->message);

            return;
        }
    }
}
