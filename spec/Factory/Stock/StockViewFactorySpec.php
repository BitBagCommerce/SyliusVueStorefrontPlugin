<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Stock;

use BitBag\SyliusVueStorefrontPlugin\Factory\Stock\StockViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\Stock\StockView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductInterface;

final class StockViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(StockViewFactory::class);
    }

    function it_creates_stock_view(
        ProductVariantInterface $productVariant,
        ProductInterface $product
    ): void {
        $productVariant->getId()->shouldBeCalled();
        $productVariant->getProduct()->willReturn($product);
        $productVariant->getOnHand()->shouldBeCalled();
        $this->create($productVariant)->shouldBeAnInstanceOf(StockView::class);
    }
}
