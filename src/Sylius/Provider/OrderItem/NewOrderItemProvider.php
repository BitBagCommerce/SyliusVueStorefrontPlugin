<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\OrderItem;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Entity\Order\OrderItemInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface as BaseProductVariantRepositoryInterface;
use Webmozart\Assert\Assert;

final class NewOrderItemProvider implements OrderItemProviderInterface
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var BaseProductVariantRepositoryInterface */
    private $baseProductVariantRepository;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var CartItemFactoryInterface */
    private $cartItemFactory;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        BaseProductVariantRepositoryInterface $baseProductVariantRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        OrderRepositoryInterface $cartRepository,
        CartItemFactoryInterface $cartItemFactory
    ) {
        $this->productRepository = $productRepository;
        $this->baseProductVariantRepository = $baseProductVariantRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->cartRepository = $cartRepository;
        $this->cartItemFactory = $cartItemFactory;
    }

    public function provide(UpdateCart $updateCart): OrderItemInterface
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->baseProductVariantRepository->findOneBy([
            'code' => $updateCart->cartItem()->getSku(),
        ]);

        if ($productVariant) {
            return $this->createOrderItem($updateCart->cartId(), $productVariant);
        }

        /** @var ProductRepositoryInterface $product */
        $product = $this->productRepository->findOneByCode($updateCart->cartItem()->getSku());

        Assert::notNull($product, 'Product variant has not been found.');

        Assert::notEmpty($updateCart->productOptions(), 'Product variant has not been found.');

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantRepository->getVariantForOptionValuesBySku(
            $updateCart->cartItem()->getSku(),
            $updateCart->productOptions()
        );

        Assert::notNull($productVariant, 'Product variant has not been found.');

        return $this->createOrderItem($updateCart->cartId(), $productVariant);
    }

    private function createOrderItem(string $cartId, ProductVariantInterface $productVariant): OrderItemInterface
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy([
            'tokenValue' => $cartId,
            'state' => OrderInterface::STATE_CART,
        ]);

        $cartItem = $this->cartItemFactory->createForCart($cart);
        $cartItem->setVariant($productVariant);

        $cart->addItem($cartItem);

        return $cartItem;
    }
}
