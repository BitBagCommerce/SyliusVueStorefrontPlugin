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
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateCartHandler implements MessageHandlerInterface
{
    /** @var FactoryInterface */
    private $cartFactory;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var CustomerProviderInterface */
    private $customerProvider;

    public function __construct(
        FactoryInterface $cartFactory,
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
        $channel = $this->channelProvider->provide();
        $customer = $this->customerProvider->provide($createCart->cartId());

        $cart = $this->cartRepository->findLatestCartByChannelAndCustomer($channel, $customer);

        if ($cart) {
            $cart->setTokenValue($createCart->cartId());
            return;
        }

        /** @var OrderInterface $cart */
        $cart = $this->cartFactory->createNew();
        $cart->setCustomer($customer);
        $cart->setChannel($channel);
        $cart->setCurrencyCode($channel->getBaseCurrency()->getCode());
        $cart->setLocaleCode($channel->getDefaultLocale()->getCode());
        $cart->setTokenValue($createCart->cartId());

        $this->cartRepository->add($cart);
    }
}
