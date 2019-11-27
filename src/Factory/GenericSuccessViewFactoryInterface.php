<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;

interface GenericSuccessViewFactoryInterface
{
    public function create($value): GenericSuccessView;
}
