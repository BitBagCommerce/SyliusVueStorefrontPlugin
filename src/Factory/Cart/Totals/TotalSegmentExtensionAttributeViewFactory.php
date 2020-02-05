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
    /** @var TaxGrandtotalDetailsViewFactoryInterface */
    private $taxGrandtotalDetailsViewFactory;

    public function __construct(TaxGrandtotalDetailsViewFactoryInterface $taxGrandtotalDetailsViewFactory)
    {
        $this->taxGrandtotalDetailsViewFactory = $taxGrandtotalDetailsViewFactory;
    }

    public function create(SyliusOrderInterface $syliusOrder): TotalSegmentExtensionAttributeView
    {
        $totalSegmentExtensionAttribute = new TotalSegmentExtensionAttributeView();
        $totalSegmentExtensionAttribute->tax_grandtotal_details = $this->taxGrandtotalDetailsViewFactory->create($syliusOrder);

        return $totalSegmentExtensionAttribute;
    }
}
