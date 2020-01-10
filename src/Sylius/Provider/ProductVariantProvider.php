<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem\ConfigurableItemOption;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface as BaseProductVariantRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductVariantProvider implements ProductVariantProviderInterface
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var BaseProductVariantRepositoryInterface */
    private $baseProductVariantRepository;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        BaseProductVariantRepositoryInterface $baseProductVariantRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->productRepository = $productRepository;
        $this->baseProductVariantRepository = $baseProductVariantRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    /** @param ConfigurableItemOption[] $configurableItemOptions */
    public function provideForOptionValuesBySku(string $sku, array $configurableItemOptions): ProductVariantInterface
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->baseProductVariantRepository->findOneByCode($sku);

        if ($productVariant) {
            return $productVariant;
        }

        /** @var ProductRepositoryInterface $productVariant */
        $product = $this->productRepository->findOneByCode($sku);

        Assert::notNull($product, 'Product variant has not been found.');
        Assert::notEmpty($configurableItemOptions, 'Product variant has not been found.');

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantRepository->getVariantForOptionValuesBySku(
            $sku,
            $configurableItemOptions
        );

        Assert::notNull($productVariant, 'Product variant has not been found.');

        return $productVariant;
    }

    public function provideForCartItemId(OrderInterface $cart, int $itemId): ?ProductVariantInterface
    {
        /** @var OrderItemInterface $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            if ($itemId === $cartItem->getId()) {
                return $cartItem->getVariant();
            }
        }

        return null;
    }
}
