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
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;

final class TotalsViewFactory implements TotalsViewFactoryInterface
{
    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    /** @var TotalSegmentViewFactoryInterface */
    private $totalSegmentViewFactory;

    public function __construct(
        CartItemViewFactoryInterface $cartItemViewFactory,
        TotalSegmentViewFactoryInterface $totalSegmentViewFactory
    ) {
        $this->cartItemViewFactory = $cartItemViewFactory;
        $this->totalSegmentViewFactory = $totalSegmentViewFactory;
    }

    public function create(SyliusOrderInterface $syliusOrder): TotalsView
    {
        $totalsView = new TotalsView();
        $totalsView->grand_total;
        $totalsView->subtotal;
        $totalsView->discount_amount;
        $totalsView->subtotal_with_discount;
        $totalsView->shipping_amount;
        $totalsView->shipping_discount_amount;
        $totalsView->tax_amount;
        $totalsView->shipping_tax_amount;
        $totalsView->base_shipping_tax_amount;
        $totalsView->subtotal_incl_tax;
        $totalsView->shipping_incl_tax;
        $totalsView->base_currency_code;
        $totalsView->quote_currency_code;
        $totalsView->items_qty;
        $totalsView->items = $this->cartItemViewFactory->createList($syliusOrder->getItems());
        $totalsView->total_segments = $this->totalSegmentViewFactory->createList($syliusOrder->getAdjustments());

        return $totalsView;
    }
}
