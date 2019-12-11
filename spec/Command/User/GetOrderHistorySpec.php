<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\GetOrderHistory;
use PhpSpec\ObjectBehavior;

final class GetOrderHistorySpec extends ObjectBehavior
{
    private const TOKEN = 'token';

    function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetOrderHistory::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
    }
}
