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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalSegmentView;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Order\Model\AdjustmentInterface as SyliusAdjustmentInterface;
use Webmozart\Assert\Assert;

final class TotalSegmentViewFactory implements TotalSegmentViewFactoryInterface
{
    /** @var string */
    private $totalSegmentViewClass;

    /** @var TotalSegmentExtensionAttributeViewFactoryInterface */
    private $totalSegmentExtensionAttributeViewFactory;

    public function __construct(
        string $totalSegmentViewClass,
        TotalSegmentExtensionAttributeViewFactoryInterface $totalSegmentExtensionAttributeViewFactory
    ) {
        $this->totalSegmentViewClass = $totalSegmentViewClass;
        $this->totalSegmentExtensionAttributeViewFactory = $totalSegmentExtensionAttributeViewFactory;
    }

    public function create(SyliusAdjustmentInterface $syliusAdjustment, ShippingMethodInterface $shippingMethod): TotalSegmentView
    {
        return $this->createFromAdjustment($syliusAdjustment);
    }

    public function createList(SyliusOrderInterface $syliusOrder): array
    {
        $syliusShipments = $syliusOrder->getShipments();

        Assert::lessThanEq($syliusShipments->count(), 1, sprintf('More than one shipment is currently unsupported.'));

        $totalSegmentsList = [];

        $totalSegmentsList[] = $this->createTaxSummaryView($syliusOrder);
        $totalSegmentsList[] = $this->createShippingSummaryView($syliusOrder);

        if ($syliusOrder->getPromotionCoupon()) {
            $totalSegmentsList[] = $this->createPromotionSummaryView($syliusOrder);
        }

        $totalSegmentsList[] = $this->createGrandTotalSummaryView($syliusOrder);

        return $totalSegmentsList;
    }

    private function createFromAdjustment(SyliusAdjustmentInterface $syliusAdjustment): TotalSegmentView
    {
        /** @var TotalSegmentView $totalSegmentView */
        $totalSegmentView = new $this->totalSegmentViewClass();

        switch ($syliusAdjustment->getType()) {
            case AdjustmentInterface::SHIPPING_ADJUSTMENT:
            case AdjustmentInterface::TAX_ADJUSTMENT:
                $totalSegmentView->code = $syliusAdjustment->getType();

                break;
            case AdjustmentInterface::ORDER_ITEM_PROMOTION_ADJUSTMENT:
            case AdjustmentInterface::ORDER_UNIT_PROMOTION_ADJUSTMENT:
            case AdjustmentInterface::ORDER_PROMOTION_ADJUSTMENT:
                $totalSegmentView->code = 'discount';

                break;
        }

        $totalSegmentView->title = $syliusAdjustment->getLabel();
        $totalSegmentView->value = $syliusAdjustment->getAmount();

        return $totalSegmentView;
    }

    private function createTaxSummaryView(SyliusOrderInterface $syliusOrder): TotalSegmentView
    {
        /** @var TotalSegmentView $totalSegmentView */
        $totalSegmentView = new $this->totalSegmentViewClass();

        $totalSegmentView->title = TotalSegmentViewFactoryInterface::TAX_LABEL;
        $totalSegmentView->value = $syliusOrder->getTaxTotal();
        $totalSegmentView->code = AdjustmentInterface::TAX_ADJUSTMENT;
        $totalSegmentView->area = 'taxes';

        return $totalSegmentView;
    }

    private function createShippingSummaryView(SyliusOrderInterface $syliusOrder): TotalSegmentView
    {
        /** @var TotalSegmentView $totalSegmentView */
        $totalSegmentView = new $this->totalSegmentViewClass();

        $totalSegmentView->title = TotalSegmentViewFactoryInterface::SHIPPING_LABEL;
        $totalSegmentView->value = $syliusOrder->getShippingTotal();
        $totalSegmentView->code = AdjustmentInterface::SHIPPING_ADJUSTMENT;

        return $totalSegmentView;
    }

    private function createPromotionSummaryView(SyliusOrderInterface $syliusOrder): TotalSegmentView
    {
        /** @var TotalSegmentView $totalSegmentView */
        $totalSegmentView = new $this->totalSegmentViewClass();

        $totalSegmentView->title = TotalSegmentViewFactoryInterface::PROMOTION_LABEL;
        $totalSegmentView->value = $syliusOrder->getOrderPromotionTotal();
        $totalSegmentView->code = 'discount';

        return $totalSegmentView;
    }

    private function createGrandTotalSummaryView(SyliusOrderInterface $syliusOrder): TotalSegmentView
    {
        /** @var TotalSegmentView $totalSegmentView */
        $totalSegmentView = new $this->totalSegmentViewClass();

        $totalSegmentView->title = TotalSegmentViewFactoryInterface::GRAND_TOTAL_LABEL;
        $totalSegmentView->value = $syliusOrder->getTotal();
        $totalSegmentView->code = 'grand_total';
        $totalSegmentView->area = 'footer';
        $totalSegmentView->extension_attributes = $this->totalSegmentExtensionAttributeViewFactory->create($syliusOrder);

        return $totalSegmentView;
    }
}
