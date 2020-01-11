<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ProductVariant;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface as BaseProductVariantRepositoryInterface;
use Webmozart\Assert\Assert;

final class NewInCartProductVariantProvider implements ProductVariantProviderInterface
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

    public function provide(CommandInterface $command): ProductVariantInterface
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->baseProductVariantRepository->findOneByCode($command->cartItem()->getSku());

        if ($productVariant) {
            return $productVariant;
        }

        /** @var ProductRepositoryInterface $productVariant */
        $product = $this->productRepository->findOneByCode($command->cartItem()->getSku());

        Assert::notNull($product, 'Product variant has not been found.');
        Assert::notEmpty($command->productOptions(), 'Product variant has not been found.');

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantRepository->getVariantForOptionValuesBySku(
            $command->cartItem()->getSku(),
            $command->productOptions()
        );

        Assert::notNull($productVariant, 'Product variant has not been found.');

        return $productVariant;
    }
}
