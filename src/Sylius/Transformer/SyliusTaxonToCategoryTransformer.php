<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Document\Category;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Repository\ProductTaxonRepository;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\TaxonInterface;

final class SyliusTaxonToCategoryTransformer implements SyliusTaxonToCategoryTransformerInterface
{
    /** @var ProductTaxonRepository */
    private $productTaxonRepository;

    public function __construct(ProductTaxonRepository $productTaxonRepository)
    {
        $this->productTaxonRepository = $productTaxonRepository;
    }

    public function transform(TaxonInterface $taxon): Category
    {
        return new Category(
            $taxon->getId(),
            $taxon->getId(),
            $taxon->getParent() ? $taxon->getParent()->getId() : null,
            $taxon->getName(),
            true,
            $taxon->getPosition(),
            $taxon->getLevel()+2,
            $this->productTaxonRepository->getAmountOfProductVariants($taxon),
            $this->processChildren($taxon->getChildren()),
            $this->buildChildrenIds($taxon->getChildren()),
            new \DateTime(),
            new \DateTime(),
            $taxon->getName(),
            [], //sortBy
            true,
            null,
            false,
            null,
            count($taxon->getChildren()),
            \strtolower($taxon->getName()),
            \strtolower(\str_replace(' ', '', $taxon->getFullname())),
            \strtolower(\str_replace(' ', '', $taxon->getFullname())) . '.html'
        );
    }

    private function processChildren(Collection $childTaxons): array
    {
        $childrenData = [];

        foreach ($childTaxons as $taxon) {
            $childrenData[] = $this->transform($taxon);
        }

        return $childrenData;
    }

    /** @param Collection|TaxonInterface[] $childTaxons */
    private function buildChildrenIds(Collection $childTaxons): string
    {
        return \implode(', ', \array_map(static function (TaxonInterface $taxon) {
            return $taxon->getId();
        }, $childTaxons->toArray()));
    }
}
