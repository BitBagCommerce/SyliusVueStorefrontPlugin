<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery\Media;

final class MediaGallery
{
//    TODO media_gallery doesnt appear in VS Docs, is present only in demo app
    private const MEDIA_GALLERY = 'media_gallery';

    /** @var Media[] */
    private $media;

    public function __construct(array $media)
    {
        $this->media = $media;
    }

    public function toArray(): array
    {
        return [
            self::MEDIA_GALLERY => $this->media,
        ];
    }
}
