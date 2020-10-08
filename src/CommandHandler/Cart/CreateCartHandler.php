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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Factory\CartFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateCartHandler implements MessageHandlerInterface
{
    /** @var CartFactoryInterface */
    private $cartFactory;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var CustomerProviderInterface */
    private $customerProvider;

    public function __construct(
        CartFactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider
    ) {
        $this->cartFactory = $cartFactory;
        $this->cartRepository = $cartRepository;
        $this->channelProvider = $channelProvider;
        $this->customerProvider = $customerProvider;
    }

    public function __invoke(CreateCart $createCart): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelProvider->provide();

        /** @var CustomerInterface $customer */
        $customer = $this->customerProvider->provide($createCart->cartId());

        if ($customer !== null) {
            $cart = $this->cartRepository->findLatestCartByChannelAndCustomer($channel, $customer);

            if (!$cart instanceof OrderInterface) {
                $cart = $this->cartFactory->createForCustomerAndChannel($customer, $channel);

                $cart->setState(OrderInterface::STATE_CART);
                $cart->setPaymentState(OrderInterface::STATE_CART);

                $this->cartRepository->add($cart);
            }

            $cart->setTokenValue($createCart->cartId());

            return;
        }

        $cart = $this->cartFactory->createForChannel($channel);

        $cart->setState(OrderInterface::STATE_CART);
        $cart->setPaymentState(OrderInterface::STATE_CART);

        $cart->setTokenValue($createCart->cartId());

        $this->cartRepository->add($cart);
    }
}
