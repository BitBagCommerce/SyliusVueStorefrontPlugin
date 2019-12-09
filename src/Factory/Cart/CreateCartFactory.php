<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
use Ramsey\Uuid\Uuid;

final class CreateCartFactory implements CreateCartFactoryInterface
{
    public function createFromDTO(CreateCartRequest $createCartRequest): CreateCart
    {
        $cartId = Uuid::uuid4()->toString();
        return new CreateCart($createCartRequest->getToken(), $cartId);
    }
}
