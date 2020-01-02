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
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Order\Model\AdjustmentInterface as SyliusAdjustmentInterface;
use Webmozart\Assert\Assert;

final class TotalSegmentViewFactory implements TotalSegmentViewFactoryInterface
{
    public function create(SyliusAdjustmentInterface $syliusAdjustment, ShippingMethodInterface $shippingMethod): TotalSegmentView
    {
        return $this->createFromAdjustment($syliusAdjustment, $shippingMethod);
    }

    public function createList(SyliusOrderInterface $syliusOrder): array
    {
        $syliusAdjustments = $syliusOrder->getAdjustments();
        $syliusShipments = $syliusOrder->getShipments();
        Assert::lessThanEq($syliusShipments->count(), 1, sprintf('More than one shipment is currently unsupported.'));

        $totalSegmentsList = [];

        foreach ($syliusAdjustments as $syliusAdjustment) {
            $totalSegmentsList[] = $this->createFromAdjustment($syliusAdjustment, $syliusOrder->getShipments()->first()->getMethod());
        }

        return $totalSegmentsList;
    }

    private function createFromAdjustment(SyliusAdjustmentInterface $syliusAdjustment, ShippingMethodInterface $shippingMethod): TotalSegmentView
    {
        $totalSegmentView = new TotalSegmentView();
        $totalSegmentView->code = $shippingMethod->getCode();
        $totalSegmentView->title = $syliusAdjustment->getLabel();
        $totalSegmentView->value = $syliusAdjustment->getAmount();
        $totalSegmentView->area = $shippingMethod->getCode();

        return $totalSegmentView;
    }
}
