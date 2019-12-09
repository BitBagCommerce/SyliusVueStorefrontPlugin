<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;

interface CreateCartFactoryInterface
{
    public function createFromDTO(CreateCartRequest $createCartRequest): CreateCart;
}
