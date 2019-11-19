<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductAttributeTransformerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;

final class ProductAttributeToVueStorefrontDocumentTransformer implements ModelToElasticaTransformerInterface
{
    /** @var SyliusProductAttributeTransformerInterface */
    private $syliusProductAttributeTransformer;

    public function __construct(SyliusProductAttributeTransformerInterface $syliusProductAttributeTransformer)
    {
        $this->syliusProductAttributeTransformer = $syliusProductAttributeTransformer;
    }

    /** @param $syliusProductAttribute ProductAttributeInterface */
    public function transform($syliusProductAttribute, array $fields): Document
    {
        $attribute = $this->syliusProductAttributeTransformer->transform($syliusProductAttribute);

        return new Document($attribute->getDocumentId(), $attribute->toElasticArray());
    }
}
