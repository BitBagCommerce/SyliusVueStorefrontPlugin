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

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\DeleteCart;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\CartItem;
use PhpSpec\ObjectBehavior;

final class DeleteCartSpec extends ObjectBehavior
{
    function let(): void
    {
        $cartItem = new CartItem();

        $this->beConstructedWith($cartItem, 'cart-id');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(DeleteCart::class);
    }

    function it_allows_to_access_properties_via_getters(): void
    {
        $this->cartItem()->shouldReturnAnInstanceOf(CartItem::class);
        $this->cartId()->shouldReturn('cart-id');
    }
}
