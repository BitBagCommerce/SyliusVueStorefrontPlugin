<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxonToCategoryTransformerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Core\Model\TaxonInterface;

final class TaxonToVueStorefrontDocumentTransformer implements ModelToElasticaTransformerInterface
{
    /** @var SyliusTaxonToCategoryTransformerInterface */
    private $syliusTaxonToCategoryTransformer;

    public function __construct(SyliusTaxonToCategoryTransformerInterface $syliusTaxonToCategoryTransformer)
    {
        $this->syliusTaxonToCategoryTransformer = $syliusTaxonToCategoryTransformer;
    }

    /** @param $taxon TaxonInterface */
    public function transform($taxon, array $fields): Document
    {
        $category = $this->syliusTaxonToCategoryTransformer->transform($taxon);

        return new Document($category->getDocumentId(), $category->toElasticArray());
    }
}
