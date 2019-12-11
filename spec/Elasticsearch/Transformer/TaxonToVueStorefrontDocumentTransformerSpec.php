<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Category;
use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer\TaxonToVueStorefrontDocumentTransformer;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxonToCategoryTransformerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;

final class TaxonToVueStorefrontDocumentTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxonToVueStorefrontDocumentTransformer::class);
    }

    function let(SyliusTaxonToCategoryTransformerInterface $syliusTaxonToCategoryTransformer): void
    {
        $this->beConstructedWith($syliusTaxonToCategoryTransformer);
    }

    function it_transforms_sylius_taxon_to_vue_storefront_category(
        SyliusTaxonToCategoryTransformerInterface $syliusTaxonToCategoryTransformer,
        TaxonInterface $taxon
    ): void {
        $category = new Category(
            1,
            1,
            1,
            'name',
            true,
            0,
            1,
            1,
            [],
            'children',
            new \DateTime('yesterday'),
            new \DateTime('yesterday'),
            'some/path/to/something',
            ['position', 'name', 'price'],
            true,
            'PRODUCTS',
            true,
            '1column',
            0,
            'example-key',
            'example/url/path',
            'example/request/path'
        );

        $syliusTaxonToCategoryTransformer->transform($taxon)->willReturn($category);

        $this->transform($taxon, []);
    }
}
