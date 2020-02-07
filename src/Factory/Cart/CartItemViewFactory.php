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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ProductOptionExtensionAttributeView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ProductOptionView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderItemInterface as SyliusOrderItemInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;

final class CartItemViewFactory implements CartItemViewFactoryInterface
{
    /** @var string */
    private $cartItemViewClass;

    public function __construct(string $cartItemViewClass)
    {
        $this->cartItemViewClass = $cartItemViewClass;
    }

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
        /** @var CartItemView $cartItemView */
        $cartItemView = new $this->cartItemViewClass();
        $cartItemView->item_id = $syliusOrderItem->getId();
        $cartItemView->sku = $syliusOrderItem->getVariant()->getCode();
        $cartItemView->qty = $syliusOrderItem->getQuantity();
        $cartItemView->qty_ordered = $syliusOrderItem->getQuantity();
        $cartItemView->name = $syliusOrderItem->getProductName();
        $cartItemView->price = $syliusOrderItem->getFullDiscountedUnitPrice();
        $cartItemView->price_incl_tax = $syliusOrderItem->getFullDiscountedUnitPrice();
        $cartItemView->row_total_incl_tax = $syliusOrderItem->getTotal();
        $cartItemView->quote_id = $syliusOrderItem->getOrder()->getTokenValue();
        $cartItemView->product_type = 'configurable';

        $productVariant = $syliusOrderItem->getVariant();
        $variantsCount = $productVariant->getProduct()->getVariants()->count();

        if ($variantsCount === 1) {
            $cartItemView->name = $syliusOrderItem->getProductName();
            $cartItemView->product_type = 'simple';

            return $cartItemView;
        }

        $cartItemView->product_option = new ProductOptionView();
        $cartItemView->product_option->extension_attributes = new ProductOptionExtensionAttributeView();
        $cartItemView->product_option->extension_attributes->bundle_options = [];
        $cartItemView->product_option->extension_attributes->configurable_item_options = [];
        $cartItemView->product_option->extension_attributes->custom_options = [];

        if ($productVariant) {
            $cartItemView->product_option->extension_attributes->configurable_item_options = $productVariant->getOptionValues()->map(
                static function (ProductOptionValueInterface $productOptionValue) {
                    return [
                        'option_value' => $productOptionValue->getId(),
                        'option_id' => (string) $productOptionValue->getOption()->getId(),
                    ];
                });
        }

        return $cartItemView;
    }

    public function createUpdateResponse(SyliusOrderItemInterface $syliusOrderItem): CartItemView
    {
        /** @var CartItemView $cartItemView */
        $cartItemView = new $this->cartItemViewClass;
        $cartItemView->item_id = $syliusOrderItem->getId();
        $cartItemView->sku = $syliusOrderItem->getVariant()->getCode();
        $cartItemView->qty = $syliusOrderItem->getQuantity();
        $cartItemView->name = $syliusOrderItem->getVariantName();
        $cartItemView->price = $syliusOrderItem->getUnitPrice();
        $cartItemView->quote_id = $syliusOrderItem->getOrder()->getTokenValue();
        $cartItemView->product_type = 'configurable';

        $productVariant = $syliusOrderItem->getVariant();
        $variantsCount = $productVariant->getProduct()->getVariants()->count();

        if ($variantsCount === 1) {
            $cartItemView->product_type = 'simple';

            return $cartItemView;
        }

        $cartItemView->product_option = new ProductOptionView();
        $cartItemView->product_option->extension_attributes = new ProductOptionExtensionAttributeView();
        $cartItemView->product_option->extension_attributes->bundle_options = [];
        $cartItemView->product_option->extension_attributes->configurable_item_options = [];
        $cartItemView->product_option->extension_attributes->custom_options = [];

        if ($productVariant) {
            $cartItemView->product_option->extension_attributes->configurable_item_options = $productVariant->getOptionValues()->map(
                static function (ProductOptionValueInterface $productOptionValue) {
                    return [
                        'option_value' => $productOptionValue->getId(),
                        'option_id' => (string) $productOptionValue->getOption()->getId(),
                    ];
                });
        }

        return $cartItemView;
    }
}
