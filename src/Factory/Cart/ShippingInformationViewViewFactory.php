<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

final class ShippingInformationViewViewFactory implements ShippingInformationViewFactoryInterface
{
    /** @var ExtensionAttributesViewFactoryInterface */
    private $extensionAttributesViewFactory;

    /** @var TaxGrandtotalDetailViewFactoryInterface */
    private $taxGrandTotalDetailViewFactory;

    /** @var TotalSegmentsViewFactoryInterface */
    private $totalSegmentsViewFactory;

    public function __construct(
        ExtensionAttributesViewFactoryInterface $extensionAttributesViewFactory,
        TaxGrandtotalDetailViewFactoryInterface $taxGrandTotalDetailViewFactory,
        TotalSegmentsViewFactoryInterface $totalSegmentsViewFactory
    ) {
        $this->extensionAttributesViewFactory = $extensionAttributesViewFactory;
        $this->taxGrandTotalDetailViewFactory = $taxGrandTotalDetailViewFactory;
        $this->totalSegmentsViewFactory = $totalSegmentsViewFactory;
    }


    public function create()
    {
        return [];
    }
}
