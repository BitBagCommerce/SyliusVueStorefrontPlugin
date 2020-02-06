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

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductTransformerInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class ProductToVueStorefrontDocumentTransformer implements ModelToElasticaTransformerInterface
{
    /** @var SyliusProductTransformerInterface */
    private $syliusProductTransformer;

    public function __construct(SyliusProductTransformerInterface $syliusProductTransformer)
    {
        $this->syliusProductTransformer = $syliusProductTransformer;
    }

    /** @param ProductInterface $syliusProduct */
    public function transform($syliusProduct, array $fields): Document
    {
        $product = $this->syliusProductTransformer->transform($syliusProduct);

        return new Document($product->getDocumentId(), $product->toElasticArray());
    }
}
