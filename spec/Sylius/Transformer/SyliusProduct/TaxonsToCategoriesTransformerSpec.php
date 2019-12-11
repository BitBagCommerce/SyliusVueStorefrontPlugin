<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Category;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\TaxonsToCategoriesTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;

final class TaxonsToCategoriesTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxonsToCategoriesTransformer::class);
    }

    function it_transforms(TaxonInterface $taxon): void
    {
        $taxon->getId()->willReturn(1);
        $taxon->hasChildren()->willReturn(true);
        $taxon->getName()->willReturn('name');
        $taxon->getSlug()->willReturn('example-slug');
        $taxon->getFullname()->willReturn('fullname');

        $this->transform(
            new ArrayCollection(
                [
                    $taxon->getWrappedObject(),
                ]
            )
        )->shouldReturnAnInstanceOf(Category::class);
    }
}
