<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart\Totals;

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalsView;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;

final class TotalsViewFactory implements TotalsViewFactoryInterface
{
    /** @var string */
    private $totalsViewClass;

    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    /** @var TotalSegmentViewFactoryInterface */
    private $totalSegmentViewFactory;

    public function __construct(
        string $totalsViewClass,
        CartItemViewFactoryInterface $cartItemViewFactory,
        TotalSegmentViewFactoryInterface $totalSegmentViewFactory
    ) {
        $this->totalsViewClass = $totalsViewClass;
        $this->cartItemViewFactory = $cartItemViewFactory;
        $this->totalSegmentViewFactory = $totalSegmentViewFactory;
    }

    public function create(SyliusOrderInterface $syliusOrder): TotalsView
    {
        /** @var TotalsView $totalsView */
        $totalsView = new $this->totalsViewClass();

        $totalsView->grand_total = $syliusOrder->getTotal();
        $totalsView->base_grand_total = $syliusOrder->getTotal();
        $totalsView->subtotal = $syliusOrder->getItemsTotal();
        $totalsView->base_subtotal = $syliusOrder->getItemsTotal();

        if ($syliusOrder->getPromotionCoupon()) {
            $totalsView->coupon_code = $syliusOrder->getPromotionCoupon()->getCode();
        }

        $totalsView->discount_amount = abs($syliusOrder->getOrderPromotionTotal());
        $totalsView->subtotal_with_discount = $syliusOrder->getItemsTotal();
        $totalsView->shipping_amount = $syliusOrder->getShippingTotal();
        $totalsView->shipping_discount_amount = $this->countShippingDiscount($syliusOrder);
        $totalsView->tax_amount = $syliusOrder->getTaxTotal();

        $totalsView->shipping_tax_amount = 0;
        $totalsView->base_shipping_tax_amount = 0;
        $totalsView->subtotal_incl_tax = $syliusOrder->getItemsTotal();
        $totalsView->shipping_incl_tax = $syliusOrder->getShippingTotal();

        $totalsView->base_currency_code = $syliusOrder->getCurrencyCode();
        $totalsView->quote_currency_code = $syliusOrder->getCurrencyCode();
        $totalsView->items_qty = $syliusOrder->getItems()->count();
        $totalsView->items = $this->cartItemViewFactory->createList($syliusOrder->getItems());
        $totalsView->total_segments = $this->totalSegmentViewFactory->createList($syliusOrder);

        return $totalsView;
    }

    private function countShippingDiscount(SyliusOrderInterface $syliusOrder): int
    {
        return $syliusOrder->getAdjustmentsTotal(AdjustmentInterface::ORDER_SHIPPING_PROMOTION_ADJUSTMENT);
    }
}
