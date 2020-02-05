<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\Order\CreateOrder;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\AddressInformation;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\Product;
use PhpSpec\ObjectBehavior;

final class CreateOrderSpec extends ObjectBehavior
{
    private $products;

    function let(): void
    {
        $this->products = [new Product()];

        $addressInformation = new AddressInformation();

        $this->beConstructedWith('cart-id', $addressInformation, $this->products[0]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateOrder::class);
    }

    function it_allows_to_access_properties_via_getters(): void
    {
        $this->cartId()->shouldReturn('cart-id');
        $this->products()->shouldContain($this->products[0]);
        $this->addressInformation()->shouldReturnAnInstanceOf(AddressInformation::class);
    }
}
