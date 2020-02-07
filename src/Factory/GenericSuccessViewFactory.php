<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use Symfony\Component\HttpFoundation\Response;

final class GenericSuccessViewFactory implements GenericSuccessViewFactoryInterface
{
    /** @var string */
    private $genericSuccessViewClass;

    public function __construct(string $genericSuccessViewClass)
    {
        $this->genericSuccessViewClass = $genericSuccessViewClass;
    }

    /** @param mixed $value */
    public function create($value): GenericSuccessView
    {
        /** @var GenericSuccessView $successView */
        $successView = new $this->genericSuccessViewClass();
        $successView->code = Response::HTTP_OK;
        $successView->result = $value;

        return $successView;
    }
}
