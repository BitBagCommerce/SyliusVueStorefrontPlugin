<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Category;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Repository\ProductTaxonRepository;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxonToCategoryTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductTaxonRepositoryInterface as BaseProductTaxonRepositoryInterface;

final class SyliusTaxonToCategoryTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusTaxonToCategoryTransformer::class);
    }

    function let(BaseProductTaxonRepositoryInterface $baseProductTaxonRepository): void
    {
        $this->beConstructedWith(new ProductTaxonRepository($baseProductTaxonRepository->getWrappedObject()));
    }

    function it_transforms(
        BaseProductTaxonRepositoryInterface $baseProductTaxonRepository,
        TaxonInterface $taxon,
        ProductTaxonInterface $productTaxon
    ): void {
        $taxon->getId()->willReturn(1);
        $taxon->getParent()->willReturn(null);
        $taxon->getName()->willReturn('name');
        $taxon->getPosition()->willReturn(1);
        $taxon->getLevel()->willReturn(1);
        $taxon->getChildren()->willReturn(new ArrayCollection());
        $taxon->getFullname()->willReturn('full-name');

        $productTaxon->getProduct()->willReturn(new Product());

        $baseProductTaxonRepository->findBy(Argument::any())->willReturn(
            [
                $productTaxon,
                $productTaxon
            ]
        );

        $this->transform($taxon)->shouldReturnAnInstanceOf(Category::class);
    }
}
