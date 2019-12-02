<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart\CreateCartHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class CreateCartHandlerSpec extends ObjectBehavior
{
    function let(
        FactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider
    )
    {
        $this->beConstructedWith($cartFactory, $cartRepository, $channelProvider, $customerProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateCartHandler::class);
    }

    public function it_creates_cart(
        FactoryInterface $cartFactory,
        OrderRepositoryInterface $cartRepository,
        OrderInterface $cart,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        ChannelInterface $channel,
        CustomerInterface $customer,
        CreateCart $createCart
    ): void
    {
        $channelProvider->provide()->willReturn($channel);
        $customerProvider->provide()->willReturn($customer);
        $cartFactory->createNew()->willReturn($cart);

        $cartRepository->add($cart)->shouldBeCalled();

        $this->__invoke($createCart);
    }
}
