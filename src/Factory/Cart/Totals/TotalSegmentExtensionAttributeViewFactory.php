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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalSegmentExtensionAttributeView;
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;

final class TotalSegmentExtensionAttributeViewFactory implements TotalSegmentExtensionAttributeViewFactoryInterface
{
    /** @var string */
    private $totalSegmentExtensionAttributeViewClass;

    /** @var TaxGrandtotalDetailsViewFactoryInterface */
    private $taxGrandtotalDetailsViewFactory;

    public function __construct(
        string $totalSegmentExtensionAttributeViewClass,
        TaxGrandtotalDetailsViewFactoryInterface $taxGrandtotalDetailsViewFactory
    ) {
        $this->taxGrandtotalDetailsViewFactory = $taxGrandtotalDetailsViewFactory;
        $this->totalSegmentExtensionAttributeViewClass = $totalSegmentExtensionAttributeViewClass;
    }

    public function create(SyliusOrderInterface $syliusOrder): TotalSegmentExtensionAttributeView
    {
        /** @var TotalSegmentExtensionAttributeView $totalSegmentExtensionAttributeView */
        $totalSegmentExtensionAttributeView = new $this->totalSegmentExtensionAttributeViewClass();
        $totalSegmentExtensionAttributeView->tax_grandtotal_details = $this->taxGrandtotalDetailsViewFactory->create($syliusOrder);

        return $totalSegmentExtensionAttributeView;
    }
}
