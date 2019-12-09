<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Image;

use BitBag\SyliusVueStorefrontPlugin\Controller\Image\ProcessImageAction;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Metadata\MetadataBag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

final class ProcessImageActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProcessImageAction::class);
    }

    function let(ImagineInterface $imagine): void
    {
        $this->beConstructedWith(
            $imagine,
            'path/to/project'
        );
    }

    function it_identifies_an_image_and_returns_its_metadata(
        ImagineInterface $imagine,
        ImageInterface $image
    ): void {
        $request = new Request([], [], [
            'width' => 256,
            'height' => 256,
            'operation' => 'identify',
            'relativeUrl' => 'image.jpg',
        ]);

        $imagine->setMetadataReader(Argument::any())->willReturn($imagine);

        $imagine->open('path/to/project/public/media/image/image.jpg')->willReturn($image);

        $image->metadata()->willReturn(new MetadataBag());

        $this->__invoke($request);
    }

    function it_returns_resized_image(
        ImagineInterface $imagine,
        ImageInterface $image
    ): void {
        $request = new Request([], [], [
            'width' => 256,
            'height' => 256,
            'operation' => 'resize',
            'relativeUrl' => 'image.jpg',
        ]);

        $imagine->open('path/to/project/public/media/image/image.jpg')->willReturn($image);

        $image->resize(Argument::any())->willReturn($image->getWrappedObject());

        $image->show('jpg')->shouldBeCalled();

        $this->__invoke($request);
    }
}
