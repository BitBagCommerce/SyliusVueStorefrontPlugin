<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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

    public function __construct(BaseProductTaxonRepositoryInterface $baseProductTaxonRepository)
    {
        $this->baseProductTaxonRepository = $baseProductTaxonRepository;
    }

    public function getAmountOfProductVariants(TaxonInterface $taxon): int
    {
        /** @var ProductTaxonInterface[] $productTaxons */
        $productTaxons = $this->baseProductTaxonRepository->findBy(['taxon' => $taxon]);

        $productVariantsCounter = 0;

        foreach ($productTaxons as $productTaxon) {
            $productVariantsCounter += count($productTaxon->getProduct()->getVariants());
       }

        return $productVariantsCounter;
    }
}
