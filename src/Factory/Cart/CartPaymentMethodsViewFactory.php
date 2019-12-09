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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartPaymentMethodsView;
use Doctrine\Common\Collections\Collection;

final class CartPaymentMethodsViewFactory implements CartPaymentMethodsViewFactoryInterface
{
    public function createList(Collection $payments): array
    {
        $cartPaymentMethodList = [];

        foreach ($payments as $payment) {
            $paymentView = new CartPaymentMethodsView();
            $paymentView->code = $payment->getMethod()->getCode();
            $paymentView->title = $payment->getMethod()->getName();

            $cartPaymentMethodList[] = $paymentView;
        }

        return $cartPaymentMethodList;
    }
}
