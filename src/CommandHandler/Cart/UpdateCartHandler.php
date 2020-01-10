<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\UpdateCart;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier\OrderModifierInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ProductVariantProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class UpdateCartHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ProductVariantProviderInterface */
    private $productVariantProvider;

    /** @var OrderModifierInterface */
    private $orderModifier;

    public function __construct(
        OrderRepositoryInterface $cartRepository,
        ProductVariantProviderInterface $productVariantProvider,
        OrderModifierInterface $orderModifier
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantProvider = $productVariantProvider;
        $this->orderModifier = $orderModifier;
    }

    public function __invoke(UpdateCart $updateCart): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy(['tokenValue' => $updateCart->cartId()]);

        Assert::notNull($cart, 'Cart has not been found.');

        if ($updateCart->cartItem()->getItemId())
        {
            $productVariant = $this->productVariantProvider->provideForCartItemId($cart, $updateCart->cartItem()->getItemId());
        } else {
            /** @var ProductVariantInterface $productVariant */
            $productVariant = $this->productVariantProvider->provideForOptionValuesBySku(
                $updateCart->cartItem()->getSku(),
                $updateCart->productOptions()
            );
        }

        Assert::notNull($productVariant, 'Product variant has not been found.');

        /** @var ProductInterface $product */
        $product = $productVariant->getProduct();

        Assert::true(
            in_array($cart->getChannel(), $product->getChannels()->toArray(), true),
            'Product is not in same channel as cart.'
        );

        $this->orderModifier->modify(
            $cart, $productVariant, $updateCart->cartItem()->getQuantity(), $updateCart->getOrderItemUuid()
        );
    }
}
