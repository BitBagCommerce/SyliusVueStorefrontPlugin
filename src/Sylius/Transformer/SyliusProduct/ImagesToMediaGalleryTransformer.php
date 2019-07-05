<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery;
use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery\Media;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ImageInterface;

final class ImagesToMediaGalleryTransformer implements ImagesToMediaGalleryTransformerInterface
{
    /** @param Collection|ImageInterface[] $images */
    public function transform(Collection $images): MediaGallery
    {
        $gallery = [];
        $mediaCounter = 0;

        foreach ($images as $image) {
            ++$mediaCounter;

            $gallery[] = new Media(
                'localhost:8000/media/cache/resolve/sylius_shop_product_thumbnail/' . $image->getPath(),
                $mediaCounter,
                $image->getType(),
                $image->getId()
            );
        }

        return new MediaGallery($gallery);
    }
}
