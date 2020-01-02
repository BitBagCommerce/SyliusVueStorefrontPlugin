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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\ShippingMethodsView;
use Sylius\Component\Core\Model\ShippingMethodInterface;

final class ShippingMethodsViewFactory implements ShippingMethodsViewFactoryInterface
{
    public function createList(ShippingMethodInterface ...$shippingMethods): array
    {
        $shippingMethodList = [];

        foreach ($shippingMethods as $shippingMethod) {
            $shippingMethodList[] = $this->creteFromShippingMethod($shippingMethod);
        }

        return $shippingMethodList;
    }

    private function creteFromShippingMethod(ShippingMethodInterface $shippingMethod): ShippingMethodsView
    {
        $shippingMethodsView = new ShippingMethodsView();
        $shippingMethodsView->carrier_code = $shippingMethod->getCode();
        $shippingMethodsView->method_code = $shippingMethod->getCode();
        $shippingMethodsView->carrier_title = $shippingMethod->getTranslation()->getName();
        $shippingMethodsView->method_title = $shippingMethod->getTranslation()->getName();
        $shippingMethodsView->amount = $shippingMethod->getConfiguration();
        $shippingMethodsView->base_amount = null;
        $shippingMethodsView->available = $shippingMethod->isEnabled();
        $shippingMethodsView->error_message = '';
        $shippingMethodsView->price_excl_tax = 0;
        $shippingMethodsView->price_incl_tax = 0;

        return $shippingMethodsView;
    }
}
