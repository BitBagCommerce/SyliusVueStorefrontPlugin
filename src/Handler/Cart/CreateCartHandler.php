<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Handler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

final class CreateCartHandler
{
    /** @var FactoryInterface */
    private $cartFactory;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var string */
    private $channelCode;

    public function __construct(
        FactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelRepositoryInterface $channelRepository,
        string $channelCode
    ) {
        $this->cartFactory = $cartFactory;
        $this->cartRepository = $cartRepository;
        $this->channelRepository = $channelRepository;
        $this->channelCode = $channelCode;
    }

    public function __invoke(CreateCart $createCart): void
    {
        /** @var ChannelInterface|null $channel */
        $channel = $this->channelRepository->findOneByCode($this->channelCode);

        Assert::notNull($channel, sprintf('Channel with %s code has not been found.', $this->channelCode));

        /** @var OrderInterface $cart */
        $cart = $this->cartFactory->createNew();
        $cart->setChannel($channel);
        $cart->setCurrencyCode($channel->getBaseCurrency()->getCode());
        $cart->setLocaleCode($channel->getDefaultLocale()->getCode());
        $cart->setTokenValue($createCart->cartId());

        $this->cartRepository->add($cart);
    }
}
