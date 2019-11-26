<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use Symfony\Component\HttpFoundation\Response;

final class GenericSuccessViewFactory implements GenericSuccessViewFactoryInterface
{
    /** @param mixed $value */
    public function create($value): GenericSuccessView
    {
        $successView = new GenericSuccessView();
        $successView->code = Response::HTTP_OK;
        $successView->result = $value;

        return $successView;
    }
}
