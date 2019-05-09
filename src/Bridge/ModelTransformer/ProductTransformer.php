<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\ModelTransformer;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductTransformer implements ModelToElasticaTransformerInterface
{
    /** @param $productVariant ProductVariantInterface */
    public function transform($productVariant, array $fields): Document
    {
        $values = Product::fromSyliusProductVariant($productVariant)->toElasticArray();


        return  new Document($values[Product::ENTITY_ID], $values);
    }
}
