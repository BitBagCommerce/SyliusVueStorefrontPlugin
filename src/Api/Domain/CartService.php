<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Api\Domain;

use BitBag\SyliusVueStorefrontPlugin\Api\Domain\Model\PaymentMethod;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Model\PromotionCouponInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Promotion\Repository\PromotionCouponRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class CartService
{
    private const ACTION_COMPLETED_SUCCESSFULLY = true;

    /** @var FactoryInterface */
    private $cartFactory;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var string */
    private $channelCode;

    /** @var PromotionCouponRepositoryInterface */
    private $couponRepository;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var PromotionCouponEligibilityCheckerInterface */
    private $couponEligibilityChecker;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    public function __construct(
        FactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelRepositoryInterface $channelRepository,
        PromotionCouponRepositoryInterface $couponRepository,
        string $channelCode,
        OrderProcessorInterface $orderProcessor,
        PromotionCouponEligibilityCheckerInterface $couponEligibilityChecker,
        PaymentMethodRepositoryInterface $paymentMethodRepository
    ) {
        $this->cartFactory = $cartFactory;
        $this->cartRepository = $cartRepository;
        $this->channelRepository = $channelRepository;
        $this->channelCode = $channelCode;
        $this->couponRepository = $couponRepository;
        $this->orderProcessor = $orderProcessor;
        $this->couponEligibilityChecker = $couponEligibilityChecker;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function createCart(Request $request): Payload
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelRepository->findOneByCode($this->channelCode);

        Assert::notNull($channel);

        /** @var OrderInterface $cart */
        $cart = $this->cartFactory->createNew();
        $cart->setChannel($channel);
        $cart->setCurrencyCode($channel->getBaseCurrency()->getCode());
        $cart->setLocaleCode($channel->getDefaultLocale()->getCode());
        //        $cart->setTokenValue();

        $this->cartRepository->add($cart);

        return new Payload('cart id or mixed guid');
    }

    public function pullCart(Request $request): Payload
    {
        return new Payload();
    }

    public function updateCart(Request $request): Payload
    {
        return new Payload();
    }

    public function deleteCart(Request $request): Payload
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneByTokenValue($request->query->get('cartId'));

        Assert::notNull($cart, sprintf('Cart has not been found.'));
//        Assert::same(OrderInterface::STATE_CART, $cart->getState());

        $this->cartRepository->remove($cart);

        return new Payload(self::ACTION_COMPLETED_SUCCESSFULLY);
    }

    public function applyCoupon(Request $request): Payload
    {
        /** @var PromotionCouponInterface $coupon */
        $coupon = $this->couponRepository->findOneBy(['code' => $request->query->get('coupon')]);

        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneByTokenValue($request->query->get('cartId'));

        Assert::true($this->couponEligibilityChecker->isEligible($cart, $coupon));

        $cart->setPromotionCoupon($coupon);

        $this->orderProcessor->process($cart);

        return new Payload(self::ACTION_COMPLETED_SUCCESSFULLY);
    }

    public function deleteCoupon(Request $request): Payload
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneByTokenValue($request->query->get('cartId'));

        Assert::notNull($cart, sprintf('Cart has not been found.'));

        $cart->setPromotionCoupon(null);

        $this->orderProcessor->process($cart);

        return new Payload(self::ACTION_COMPLETED_SUCCESSFULLY);
    }

    public function getAppliedCoupon(Request $request): Payload
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneByTokenValue($request->query->get('cartId'));

        if (null === $cart->getPromotionCoupon()) {
            return new Payload(null);
        }

        return new Payload($cart->getPromotionCoupon()->getCode());
    }

    public function syncTotals(Request $request): Payload
    {
        return new Payload();
    }

    public function getPaymentMethods(Request $request): Payload
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneByTokenValue($request->query->get('cartId'));

        /** @var PaymentMethodInterface[] $paymentMethods */
        $paymentMethods = $this->paymentMethodRepository->findEnabledForChannel($cart->getChannel());

        $data = [];

        foreach ($paymentMethods as $paymentMethod) {
            $data[] = new PaymentMethod($paymentMethod->getCode(), $paymentMethod->getName());
        }

        return new Payload($data);
    }

    public function setShippingMethods(Request $request): Payload
    {
        return new Payload();
    }

    public function setShippingInformation(Request $request): Payload
    {
        return new Payload();
    }

    public function collectTotals(Request $request): Payload
    {
        return new Payload();
    }
}
