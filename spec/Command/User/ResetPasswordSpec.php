<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use PhpSpec\ObjectBehavior;

final class ResetPasswordSpec extends ObjectBehavior
{
    private const EMAIL = 'email';

    function let(): void
    {
        $this->beConstructedWith(
            self::EMAIL
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetPassword::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->email()->shouldReturn(self::EMAIL);
    }
}
