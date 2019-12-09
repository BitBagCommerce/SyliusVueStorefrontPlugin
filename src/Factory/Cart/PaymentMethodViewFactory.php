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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\PaymentMethodView;
use Sylius\Component\Core\Model\PaymentMethodInterface as SyliusPaymentMethodInterface;

final class PaymentMethodViewFactory implements PaymentMethodViewFactoryInterface
{
    public function createList(array $syliusPaymentMethods): array
    {
        $paymentMethodsList = [];

        foreach ($syliusPaymentMethods as $syliusPaymentMethod) {
            $paymentMethodsList[] = $this->createFromPaymentMethod($syliusPaymentMethod);
        }

        return $paymentMethodsList;
    }

    private function createFromPaymentMethod(SyliusPaymentMethodInterface $syliusPaymentMethod): PaymentMethodView
    {
        $paymentMethodView = new PaymentMethodView();
        $paymentMethodView->code = $syliusPaymentMethod->getCode();
        $paymentMethodView->title = $syliusPaymentMethod->getName();

        return $paymentMethodView;
    }
}
