<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\GetUser;
use PhpSpec\ObjectBehavior;

class GetUserSpec extends ObjectBehavior
{
    private const TOKEN = 'token';

    public function let(): void
    {
        $this->beConstructedWith(
            self::TOKEN
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GetUser::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->token()->shouldReturn(self::TOKEN);
    }
}
