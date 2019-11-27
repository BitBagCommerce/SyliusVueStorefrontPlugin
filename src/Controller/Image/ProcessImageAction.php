<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Image;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Metadata\ExifMetadataReader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProcessImageAction
{
    private const IMAGE_DIRECTORY_PATH = '/public/media/image/';
    private const OPERATION_CROP = 'crop';
    private const OPERATION_FIT = 'fit';
    private const OPERATION_RESIZE = 'resize';
    private const OPERATION_IDENTIFY = 'identify';

    /** @var ImagineInterface */
    private $imagine;

    /** @var string */
    private $projectDir;

    public function __construct(ImagineInterface $imagine, string $projectDir)
    {
        $this->imagine = $imagine;
        $this->projectDir = $projectDir;
    }

    public function __invoke(Request $request): Response
    {
        $width = $request->attributes->get('width');
        $height = $request->attributes->get('height');
        $operation = $request->attributes->get('operation');
        $relativeUrl = $request->attributes->get('relativeUrl');

        $path = $this->projectDir . self::IMAGE_DIRECTORY_PATH . $relativeUrl;

        if (self::OPERATION_IDENTIFY === $operation) {
            $image = $this->imagine
                ->setMetadataReader(new ExifMetadataReader())
                ->open($path)
            ;

            return new JsonResponse($image->metadata()->toArray());
        }

        $image = $this->imagine->open($path);
        $image->resize(new Box($width, $height))->show('jpg');

        return new Response($image->show('jpg'));
    }
}
