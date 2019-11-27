<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\ProductLinks\Link;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductAssociationInterface;

final class ProductAssociationsToLinksTransformer implements ProductAssociationsToLinksTransformerInterface
{
    /** @param Collection|ProductAssociationInterface[] $syliusProductAssociations */
    public function transform(Collection $syliusProductAssociations): ProductLinks
    {
        $productLinks = [];
        $productLinkPosition = 1;

        foreach ($syliusProductAssociations as $syliusProductAssociation) {
            $syliusProductAssociationOwnerCode = $syliusProductAssociation->getOwner()->getCode();

            if (null === $syliusProductAssociation->getAssociatedProducts()) {
                continue;
            }

            /** @var ProductInterface $product */
            foreach ($syliusProductAssociation->getAssociatedProducts() as $product) {
                $productLinks[] = new Link(
                    $syliusProductAssociationOwnerCode,
                    $this->renameAssociationType($syliusProductAssociation->getType()->getCode()),
                    $productLinkPosition,
                    $product->getCode(),
                    count($product->getVariants()) > 1 ? 'configurable' : 'simple'
                );

                $productLinkPosition++;
            }
        }

        return new ProductLinks($productLinks);
    }

    private function renameAssociationType(string $syliusAssociationTypeCode): string
    {
        switch ($syliusAssociationTypeCode){
            case 'similar_products':
                return 'related';
            case 'xyz':
                return 'associated';
            case 'up-sell':
            default:
                return 'upsell';
        }
    }
}
