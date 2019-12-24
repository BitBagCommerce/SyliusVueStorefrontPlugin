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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderItemInterface as SyliusOrderItemInterface;

final class CartItemViewFactory implements CartItemViewFactoryInterface
{
    public function create(SyliusOrderItemInterface $syliusOrderItem): CartItemView
    {
        return $this->createFromOrderItem($syliusOrderItem);
    }

    public function createList(Collection $syliusOrderItems): array
    {
        $cartItemsList = [];

        foreach ($syliusOrderItems as $syliusOrderItem) {
            $cartItemsList[] = $this->createFromOrderItem($syliusOrderItem);
        }

        return $cartItemsList;
    }

    private function createFromOrderItem(SyliusOrderItemInterface $syliusOrderItem): CartItemView
    {
        $cartItemView = new CartItemView();
        $cartItemView->item_id = $syliusOrderItem->getId();
        $cartItemView->sku = $syliusOrderItem->getVariant()->getCode();
        $cartItemView->qty = $syliusOrderItem->getQuantity();
        $cartItemView->name = $syliusOrderItem->getProductName();
        $cartItemView->price = $syliusOrderItem->getUnitPrice();
        $cartItemView->quote_id = $syliusOrderItem->getOrder()->getNumber();
        $cartItemView->product_option = [];
        $cartItemView->price_incl_tax = $syliusOrderItem->getUnitPrice();
        $cartItemView->qty_ordered = $syliusOrderItem->getQuantity();
        $cartItemView->row_total_incl_tax = $syliusOrderItem->getSubtotal();

        return $cartItemView;
    }

    public function createUpdateResponse(SyliusOrderItemInterface $syliusOrderItem): CartItemView
    {
        $cartItemView = new CartItemView();
        $cartItemView->item_id = $syliusOrderItem->getId();
        $cartItemView->sku = $syliusOrderItem->getVariant()->getCode();
        $cartItemView->qty = $syliusOrderItem->getQuantity();
        $cartItemView->name = $syliusOrderItem->getVariantName();
        $cartItemView->price = $syliusOrderItem->getUnitPrice();
        $cartItemView->quote_id = $syliusOrderItem->getOrder()->getNumber();

        return $cartItemView;
    }
}
