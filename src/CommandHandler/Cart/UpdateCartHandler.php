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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\OrderItem\OrderItemProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class UpdateCartHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var OrderItemProviderInterface */
    private $productVariantProvider;

    /** @var OrderModifierInterface */
    private $orderModifier;

    public function __construct(
        OrderRepositoryInterface $cartRepository,
        OrderItemProviderInterface $productVariantProvider,
        OrderModifierInterface $orderModifier
    ) {
        $this->cartRepository = $cartRepository;
        $this->productVariantProvider = $productVariantProvider;
        $this->orderModifier = $orderModifier;
    }

    public function __invoke(UpdateCart $updateCart): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->cartRepository->findOneBy([
            'tokenValue' => $updateCart->cartId(),
            'state' => OrderInterface::STATE_CART,
        ]);

        Assert::notNull($cart, 'Cart has not been found.');

        $cartItem = $this->productVariantProvider->provide($updateCart);

        /** @var ProductInterface $product */
        $product = $cartItem->getProduct();

        Assert::true(
            in_array($cart->getChannel(), $product->getChannels()->toArray(), true),
            'Product is not in same channel as cart.'
        );

        $this->orderModifier->modify(
            $cart, $cartItem, $updateCart->cartItem()->getQuantity(), $updateCart->getOrderItemUuid()
        );
    }
}
