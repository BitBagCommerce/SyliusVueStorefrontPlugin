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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\Totals\TotalsViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\ShippingInformationView;
use Sylius\Component\Core\Model\OrderInterface as SyliusOrderInterface;

final class ShippingInformationViewFactory implements ShippingInformationViewFactoryInterface
{
    /** @var string */
    private $shippingInformationViewClass;

    /** @var PaymentMethodViewFactoryInterface */
    private $paymentMethodViewFactory;

    /** @var TotalsViewFactoryInterface */
    private $totalsViewFactory;

    public function __construct(
        string $shippingInformationViewClass,
        PaymentMethodViewFactoryInterface $paymentMethodViewFactory,
        TotalsViewFactoryInterface $totalsViewFactory
    ) {
        $this->shippingInformationViewClass = $shippingInformationViewClass;
        $this->paymentMethodViewFactory = $paymentMethodViewFactory;
        $this->totalsViewFactory = $totalsViewFactory;
    }

    public function create(array $syliusPaymentMethods, SyliusOrderInterface $syliusOrder): ShippingInformationView
    {
        /** @var ShippingInformationView $shippingInformationView */
        $shippingInformationView = new $this->shippingInformationViewClass();
        $shippingInformationView->payment_methods = $this->paymentMethodViewFactory->createList($syliusPaymentMethods);
        $shippingInformationView->totals = $this->totalsViewFactory->create($syliusOrder);

        return $shippingInformationView;
    }
}
