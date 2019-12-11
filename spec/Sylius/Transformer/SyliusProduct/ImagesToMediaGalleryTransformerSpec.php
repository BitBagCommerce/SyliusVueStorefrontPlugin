<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\MediaGallery;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ImagesToMediaGalleryTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ImageInterface;

final class ImagesToMediaGalleryTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ImagesToMediaGalleryTransformer::class);
    }

    function it_transforms(ImageInterface $image): void
    {
        $image->getPath()->willReturn('some/path/to/image.jpg');
        $image->getType()->willReturn('image-type');
        $image->getId()->willReturn(1);

        $this->transform(
            new ArrayCollection(
                [
                   $image->getWrappedObject(),
                   $image->getWrappedObject(),
                ]
            )
        )->shouldReturnAnInstanceOf(MediaGallery::class);
    }
}
