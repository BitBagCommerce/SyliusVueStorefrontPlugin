<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Order;

use BitBag\SyliusVueStorefrontPlugin\Controller\Order\CreateOrderAction;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use PhpSpec\ObjectBehavior;

class CreateOrderActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateOrderAction::class);
    }

    function let(
        LoggedInShopUserProviderInterface $loggedInUserProvider
    ): void
    {
        $this->beConstructedWith(
            $loggedInUserProvider
        );
    }
}
