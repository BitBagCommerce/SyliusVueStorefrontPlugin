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
use Sylius\Component\Core\Model\TaxonInterface;

final class SyliusTaxonToCategoryTransformer implements SyliusTaxonToCategoryTransformerInterface
{
    /** @var ProductTaxonRepository */
    private $productTaxonRepository;

    /** @var array */
    private $childrenData;

    public function __construct(ProductTaxonRepository $productTaxonRepository)
    {
        $this->productTaxonRepository = $productTaxonRepository;
    }

    public function transform(TaxonInterface $taxon): Category
    {
        $this->childrenData = [];

        return new Category(
            $taxon->getId(),
            $taxon->getId(),
            $taxon->getParent() ? $taxon->getParent()->getId() : null,
            $taxon->getName(),
            true,
            $taxon->getPosition(),
            $taxon->getLevel() + 2,
            $this->productTaxonRepository->getAmountOfProducts($taxon),
            $this->processChildren($taxon),
            $this->buildPath($taxon),
            count($taxon->getChildren()),
            \strtolower(sprintf('%d_%s', $taxon->getId(), \str_replace([' ', '-'], '_', $taxon->getName()))),
            \strtolower(\str_replace(' ', '', $taxon->getFullname()))
        );
    }

    private function processChildren(TaxonInterface $taxon): array
    {
        foreach ($taxon->getChildren() as $child) {
            $this->childrenData[] = ['id' => $child->getId()];
            if ($child->hasChildren()) {
                $this->processChildren($child);
            }
        }

        return $this->childrenData;
    }

    private function buildPath(TaxonInterface $taxon): string
    {
        $path = (string) ($taxon->getId());

        while ($taxon->getParent()) {
            $path = sprintf('%s/%s', $taxon->getParent()->getId(), $path);
            $taxon = $taxon->getParent();
        }

        return $path;
    }
}
