<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\PullCart;
use PhpSpec\ObjectBehavior;

class PullCartSpec extends ObjectBehavior
{
    private const TOKEN = 'token';
    private const CART_ID = "pull-spec-spec";

    public function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN,
            self::CART_ID
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PullCart::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
        $this->cartId()->shouldReturn(self::CART_ID);
    }
}
