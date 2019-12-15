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

use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\PaymentView;
use Sylius\Component\Core\Model\PaymentInterface;

final class PaymentViewFactory implements PaymentViewFactoryInterface
{
    public function create(PaymentInterface $syliusPayment): PaymentView
    {
        return $this->createFromPayment($syliusPayment);
    }

    private function createFromPayment(PaymentInterface $syliusPayment): PaymentView
    {
        $paymentView = new PaymentView();
        $paymentView->account_status = null;
        $paymentView->additional_information[] = [
            $syliusPayment->getMethod() ? $syliusPayment->getMethod()->getName() : 'undefined',
        ];
        $paymentView->amount_ordered = $syliusPayment->getAmount();
        $paymentView->base_amount_ordered = $syliusPayment->getAmount();
        $paymentView->base_shipping_amount = $syliusPayment->getOrder()->getShippingTotal();
        $paymentView->cc_last4 = null;
        $paymentView->entity_id = $syliusPayment->getId();
        $paymentView->method = $syliusPayment->getMethod()->getCode();
        $paymentView->parent_id = $syliusPayment->getOrder()->getId();
        $paymentView->shipping_amount = $syliusPayment->getOrder()->getShippingTotal();

        return $paymentView;
    }
}
