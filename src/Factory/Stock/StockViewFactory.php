<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Stock;

use BitBag\SyliusVueStorefrontPlugin\View\Stock\StockView;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class StockViewFactory implements StockViewFactoryInterface
{
    public function create(ProductVariantInterface $productVariant): StockView
    {
        return $this->createFromProductVariant($productVariant);
    }

    public function createList(ProductVariantInterface ...$productsVariants): array
    {
        $stocksList = [];

        foreach ($productsVariants as $productVariant) {
            $stocksList[] = $this->createFromProductVariant($productVariant);
        }

        return $stocksList;
    }

    private function createFromProductVariant(ProductVariantInterface $productVariant): StockView
    {
        $stockView = new StockView();
        $stockView->product_id = $productVariant->getProduct()->getId();
        $stockView->qty = $productVariant->getOnHand();
        $stockView->is_in_stock = $productVariant->getOnHand() > 0;

        return $stockView;
    }
}
