<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Category;
use BitBag\SyliusVueStorefrontPlugin\Document\Product;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableOptions;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\Price;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\StockItem;
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer\ProductToVueStorefrontDocumentTransformer;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductTransformerInterface;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ProductInterface;

final class ProductToVueStorefrontDocumentTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductToVueStorefrontDocumentTransformer::class);
    }

    function let(SyliusProductTransformerInterface $syliusProductTransformer): void
    {
        $this->beConstructedWith($syliusProductTransformer);
    }

    function it_transforms(
        SyliusProductTransformerInterface $syliusProductTransformer,
        ProductInterface $syliusProduct
    ): void {
        $product = new Product(
            1,
            new Product\Details(
                1,
                1,
                1,
                'example-type',
                'sku12345',
                'example-key',
                'name',
                1200.50,
                1,
                1,
                new \DateTime('yesterday'),
                new \DateTime('yesterday'),
                5,
                'ean',
                null,
                true,
                'status',
                1,
                'tax-classname',
                'description',
                'desc',
                1,
                1,
                [],
                [],
                [],
                true
            ),
            new Product\Stock(1, 1, 1, 1),
            new Product\Category([], []),
            new MediaGallery([]),
            new ConfigurableChildren([]),
            new ConfigurableOptions([]),
            new ProductLinks([]),
            new Price(),
            new StockItem()
        );

        $syliusProductTransformer->transform($syliusProduct)->willReturn($product);

        $this->transform($syliusProduct, []);
    }
}
