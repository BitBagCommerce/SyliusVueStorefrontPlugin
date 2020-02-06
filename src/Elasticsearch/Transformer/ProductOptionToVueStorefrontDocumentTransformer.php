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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductOptionToAttributeTransformerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;

final class ProductOptionToVueStorefrontDocumentTransformer implements ModelToElasticaTransformerInterface
{
    /** @var SyliusProductOptionToAttributeTransformerInterface */
    private $syliusProductOptionToAttributeTransformer;

    public function __construct(SyliusProductOptionToAttributeTransformerInterface $syliusProductOptionToAttributeTransformer)
    {
        $this->syliusProductOptionToAttributeTransformer = $syliusProductOptionToAttributeTransformer;
    }

    /** @param ProductOptionInterface $syliusProductOption */
    public function transform($syliusProductOption, array $fields): Document
    {
        $attribute = $this->syliusProductOptionToAttributeTransformer->transform($syliusProductOption);

        return new Document($attribute->getDocumentId(), $attribute->toElasticArray());
    }
}
