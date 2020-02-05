<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Repository;

use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Core\Repository\ProductTaxonRepositoryInterface as BaseProductTaxonRepositoryInterface;

final class ProductTaxonRepository
{
    /** @var BaseProductTaxonRepositoryInterface */
    private $baseProductTaxonRepository;

    /** @var int[] */
    private $childrenIds = [];

    public function __construct(BaseProductTaxonRepositoryInterface $baseProductTaxonRepository)
    {
        $this->baseProductTaxonRepository = $baseProductTaxonRepository;
    }

    public function getAmountOfProducts(TaxonInterface $taxon): int
    {
        $this->childrenIds = [];
        $this->getChildrenIdsRecursive($taxon);

        /** @var ProductTaxonInterface[] $productTaxons */
        $productTaxons = $this->baseProductTaxonRepository->findBy(['taxon' => $this->childrenIds]);

        return count($productTaxons);
    }

    private function getChildrenIdsRecursive(TaxonInterface $taxon): void
    {
        $this->childrenIds[] = $taxon;

        foreach ($taxon->getChildren() as $child) {
            if ($child->hasChildren()) {
                $this->getChildrenIdsRecursive($child);
            }
        }
    }
}
