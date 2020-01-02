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

use BitBag\SyliusVueStorefrontPlugin\Factory\Common\AddressViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Common\AddressView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingView;
use Sylius\Component\Core\Model\OrderInterface;

final class ShippingViewFactory implements ShippingViewFactoryInterface
{
    /** @var AddressViewFactoryInterface */
    private $addressViewFactory;

    /** @var ShippingTotalViewFactoryInterface */
    private $shippingTotalViewFactory;

    public function __construct(
        AddressViewFactoryInterface $addressViewFactory,
        ShippingTotalViewFactoryInterface $shippingTotalViewFactory
    ) {
        $this->addressViewFactory = $addressViewFactory;
        $this->shippingTotalViewFactory = $shippingTotalViewFactory;
    }

    public function create(OrderInterface $syliusOrder): ShippingView
    {
        return $this->createFromOrder($syliusOrder);
    }

    public function createList(array $syliusOrders): array
    {
        $shippingsList = [];

        foreach ($syliusOrders as $syliusOrder) {
            $shippingsList[] = $this->createFromOrder($syliusOrder);
        }

        return $shippingsList;
    }

    private function createFromOrder(OrderInterface $syliusOrder): ShippingView
    {
        $shippingView = new ShippingView();

        if ($syliusOrder->getShippingAddress()) {
            $shippingView->address = $this->addressViewFactory->create($syliusOrder->getShippingAddress());
        } else {
            $shippingView->address = new AddressView();
        }

        $shippingView->method = '';
        if ($syliusOrder->getPayments()->first()) {
            $shippingView->method = $syliusOrder->getPayments()->first()->getMethod()->getName();
        }

        $shippingView->total = $this->shippingTotalViewFactory->create($syliusOrder);

        return $shippingView;
    }
}
