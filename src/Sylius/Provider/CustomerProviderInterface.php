<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use Sylius\Component\Customer\Model\CustomerInterface;

interface CustomerProviderInterface
{
    public function provide(?string $cartId = null): CustomerInterface;
}
