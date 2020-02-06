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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategoryToTaxRuleTransformerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;

final class TaxCategoryToVueStorefrontDocumentTransformer implements ModelToElasticaTransformerInterface
{
    /** @var SyliusTaxCategoryToTaxRuleTransformerInterface */
    private $syliusTaxCategoryTransformer;

    public function __construct(SyliusTaxCategoryToTaxRuleTransformerInterface $syliusTaxCategoryTransformer)
    {
        $this->syliusTaxCategoryTransformer = $syliusTaxCategoryTransformer;
    }

    /** @param TaxCategoryInterface $syliusTaxCategory */
    public function transform($syliusTaxCategory, array $fields): Document
    {
        $taxRule = $this->syliusTaxCategoryTransformer->transform($syliusTaxCategory);

        return new Document($taxRule->getDocumentId(), $taxRule->toElasticArray());
    }
}
