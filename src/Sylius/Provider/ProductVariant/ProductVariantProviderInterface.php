<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ProductVariant;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface ProductVariantProviderInterface
{
    public function provide(CommandInterface $command): ProductVariantInterface;
}
