<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use PhpSpec\ObjectBehavior;

final class CreateCartSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('token');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateCart::class);
    }

    function it_allows_to_access_token_via_getter(): void
    {
        $this->token()->shouldReturn('token');
    }

    function it_allows_to_set_and_access_cart_id(): void
    {
        $this->setCartId('cart-id');
        $this->cartId()->shouldReturn('cart-id');
    }
}
