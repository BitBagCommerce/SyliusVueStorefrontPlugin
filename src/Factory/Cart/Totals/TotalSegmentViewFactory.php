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
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Order\Model\AdjustmentInterface as SyliusAdjustmentInterface;

final class TotalSegmentViewFactory implements TotalSegmentViewFactoryInterface
{
    public function create(SyliusAdjustmentInterface $syliusAdjustment): TotalSegmentView
    {
        return $this->createFromAdjustment($syliusAdjustment);
    }

    public function createList(Collection $syliusAdjustments): array
    {
        $totalSegmentsList = [];

        foreach ($syliusAdjustments as $syliusAdjustment) {
            $totalSegmentsList[] = $this->createFromAdjustment($syliusAdjustment);
        }

        return $totalSegmentsList;
    }

    private function createFromAdjustment(SyliusAdjustmentInterface $syliusAdjustment): TotalSegmentView
    {
        $totalSegmentView = new TotalSegmentView();
        $totalSegmentView->code = $syliusAdjustment->getType();
        $totalSegmentView->title = $syliusAdjustment->getLabel();
        $totalSegmentView->value = $syliusAdjustment->getAmount();
        $totalSegmentView->area = $syliusAdjustment->getType();

        return $totalSegmentView;
    }
}
