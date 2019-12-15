<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistory;

use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingTotalView;
use Sylius\Component\Core\Model\OrderInterface;

final class ShippingTotalViewFactory implements ShippingTotalViewFactoryInterface
{
    public function create(OrderInterface $syliusOrder): ShippingTotalView
    {
        return $this->createFromOrder($syliusOrder);
    }

    private function createFromOrder(OrderInterface $syliusOrder): ShippingTotalView
    {
        $shippingTotalView = new ShippingTotalView();
        $shippingTotalView->base_shipping_amount = $syliusOrder->getShippingTotal();
        $shippingTotalView->base_shipping_discount_amount = 0;
        $shippingTotalView->base_shipping_incl_tax = $syliusOrder->getShippingTotal();
        $shippingTotalView->base_shipping_tax_amount = 0;
        $shippingTotalView->shipping_amount = $syliusOrder->getShippingTotal();
        $shippingTotalView->shipping_discount_amount = 0;
        $shippingTotalView->shipping_discount_tax_compensation_amount = 0;
        $shippingTotalView->shipping_incl_tax = $syliusOrder->getShippingTotal();
        $shippingTotalView->shipping_tax_amount = 0;

        return $shippingTotalView;
    }
}
