<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use PhpSpec\ObjectBehavior;

class CreateCartSpec extends ObjectBehavior
{
    private const TOKEN = 'token';
    private const CART_ID = "create-cart-spec";

    public function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN,
            self::CART_ID
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateCart::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
        $this->cartId()->shouldReturn(self::CART_ID);
    }
}
