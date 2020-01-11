<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ProductVariant;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class CompositeProductVariantProvider implements ProductVariantProviderInterface
{
    /** @var ProductVariantProviderInterface */
    private $alreadyInCartProductVariantProvider;

    /** @var ProductVariantProviderInterface */
    private $newInCartProductVariantProvider;

    public function __construct(ProductVariantProviderInterface $alreadyInCartProductVariantProvider, ProductVariantProviderInterface $newInCartProductVariantProvider)
    {
        $this->alreadyInCartProductVariantProvider = $alreadyInCartProductVariantProvider;
        $this->newInCartProductVariantProvider = $newInCartProductVariantProvider;
    }

    public function provide(CommandInterface $command): ProductVariantInterface
    {
        if ($command->cartItem()->getItemId()) {
            return $this->alreadyInCartProductVariantProvider->provide($command);
        }

        return $this->newInCartProductVariantProvider->provide($command);
    }
}
