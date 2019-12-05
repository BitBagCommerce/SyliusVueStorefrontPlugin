<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use PhpSpec\ObjectBehavior;

class SetShippingInformationSpec extends ObjectBehavior
{
    private const TOKEN = 'token';
    private const CART_ID = "set-shipping-information-spec";
    private const ADDRESS_INFORMATION = null;

    public function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN,
            self::CART_ID,
            self::ADDRESS_INFORMATION
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SetShippingInformation::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
        $this->cartId()->shouldReturn(self::CART_ID);
        $this->addressInformation()->shouldReturn(self::ADDRESS_INFORMATION);
    }
}
