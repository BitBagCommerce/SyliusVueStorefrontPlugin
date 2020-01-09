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

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\Common\AddressViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Helper\DateHelper;
use BitBag\SyliusVueStorefrontPlugin\View\Common\AddressView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\PaymentView;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderViewFactory implements OrderViewFactoryInterface
{
    /** @var CartItemViewFactoryInterface */
    private $cartItemViewFactory;

    /** @var AddressViewFactoryInterface */
    private $addressViewFactory;

    /** @var OrderExtensionAttributesViewFactoryInterface */
    private $orderExtensionAttributesViewFactory;

    /** @var PaymentViewFactoryInterface */
    private $paymentViewFactory;

    public function __construct(
        CartItemViewFactoryInterface $cartItemViewFactory,
        AddressViewFactoryInterface $addressViewFactory,
        OrderExtensionAttributesViewFactoryInterface $orderExtensionAttributesViewFactory,
        PaymentViewFactoryInterface $paymentViewFactory
    ) {
        $this->cartItemViewFactory = $cartItemViewFactory;
        $this->addressViewFactory = $addressViewFactory;
        $this->orderExtensionAttributesViewFactory = $orderExtensionAttributesViewFactory;
        $this->paymentViewFactory = $paymentViewFactory;
    }

    public function create(OrderInterface $syliusOrder): OrderView
    {
        return $this->createFromOrder($syliusOrder);
    }

    public function createList(array $syliusOrders): array
    {
        $ordersList = [];

        /** @var OrderInterface $syliusOrder */
        foreach ($syliusOrders as $syliusOrder) {
            if (!$syliusOrder->getTokenValue()) {
                continue;
            }

            $ordersList[] = $this->createFromOrder($syliusOrder);
        }

        return $ordersList;
    }

    private function createFromOrder(OrderInterface $syliusOrder): OrderView
    {
        $orderView = new OrderView();
        $orderView->applied_rule_ids = '';
        $orderView->base_currency_code = $syliusOrder->getCurrencyCode();
        $orderView->base_discount_amount = 0;
        $orderView->base_grand_total = $syliusOrder->getTotal();
        $orderView->base_discount_tax_compensation_amount = 0;
        $orderView->base_shipping_amount = $syliusOrder->getShippingTotal();
        $orderView->base_shipping_discount_amount = 0;
        $orderView->base_shipping_incl_tax = $syliusOrder->getShippingTotal();
        $orderView->base_shipping_tax_amount = 0;
        $orderView->base_subtotal = $syliusOrder->getItemsTotal();
        $orderView->base_subtotal_incl_tax = $syliusOrder->getItemsTotal();
        $orderView->base_tax_amount = $syliusOrder->getTaxTotal();
        $orderView->base_total_due = $syliusOrder->getTotal();
        $orderView->base_to_global_rate = 0;
        $orderView->base_to_order_rate = 0;
        $orderView->billing_address_id = $syliusOrder->getBillingAddress() ? $syliusOrder->getBillingAddress()->getId() : 1;
        $orderView->created_at = $syliusOrder->getCreatedAt()->format(DateHelper::DATE_TIME_FORMAT);
        $orderView->customer_email = $syliusOrder->getCustomer()->getEmail();
        $orderView->customer_group_id = 0;
        $orderView->customer_is_guest = 0;
        $orderView->customer_note_notify = 0;
        $orderView->discount_amount = 0;
        $orderView->email_sent = 1;
        $orderView->entity_id = $syliusOrder->getId();
        $orderView->global_currency_code = $syliusOrder->getCurrencyCode();
        $orderView->grand_total = $syliusOrder->getTotal();
        $orderView->discount_tax_compensation_amount = 0;

        $orderView->increment_id = '000000000';
        if ($syliusOrder->getNumber()) {
            $orderView->increment_id = $syliusOrder->getNumber();
        }

        $orderView->is_virtual = 0;
        $orderView->order_currency_code = $syliusOrder->getCurrencyCode();
        $orderView->protect_code = '';
        $orderView->quote_id = $syliusOrder->getId();
        $orderView->shipping_amount = $syliusOrder->getShippingTotal();

        $orderView->shipping_description = '';
        if ($syliusOrder->getShipments()->first()) {
            $orderView->shipping_description = $syliusOrder->getShipments()->first()->getMethod()->getName();
        }

        $orderView->shipping_discount_amount = 0;
        $orderView->shipping_discount_tax_compensation_amount = 0;
        $orderView->shipping_incl_tax = $syliusOrder->getShippingTotal();
        $orderView->shipping_tax_amount = 0;
        $orderView->state = $syliusOrder->getState();
        $orderView->status = $syliusOrder->getCheckoutState();
        $orderView->store_currency_code = $syliusOrder->getCurrencyCode();
        $orderView->store_id = 1;
        $orderView->store_name = 'Example';
        $orderView->store_to_base_rate = 0;
        $orderView->store_to_order_rate = 0;
        $orderView->subtotal = $syliusOrder->getItemsTotal();
        $orderView->subtotal_incl_tax = $syliusOrder->getItemsTotal();
        $orderView->tax_amount = $syliusOrder->getTaxTotal();
        $orderView->total_due = $syliusOrder->getTotal();
        $orderView->total_item_count = $syliusOrder->getTotalQuantity();
        $orderView->total_qty_ordered = $syliusOrder->getTotalQuantity();
        $orderView->updated_at = $syliusOrder->getUpdatedAt()->format(DateHelper::DATE_TIME_FORMAT);
        $orderView->weight = 5;
        $orderView->items = $this->cartItemViewFactory->createList($syliusOrder->getItems());

        if ($syliusOrder->getBillingAddress()) {
            $orderView->billing_address = $this->addressViewFactory->create($syliusOrder->getBillingAddress());
        } else {
            $orderView->billing_address = new AddressView();
        }

        if ($syliusOrder->getPayments()->first()) {
            $orderView->payment = $this->paymentViewFactory->create($syliusOrder->getPayments()->first());
        } else {
            $orderView->payment = new PaymentView();
        }

        $orderView->status_histories = [];
        $orderView->extension_attributes = $this->orderExtensionAttributesViewFactory->create($syliusOrder);

        return $orderView;
    }
}
