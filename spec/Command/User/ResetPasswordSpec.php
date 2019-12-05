<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use PhpSpec\ObjectBehavior;

class ResetPasswordSpec extends ObjectBehavior
{
    private const EMAIL = 'email';

    public function let(): void
    {
        $this->beConstructedWith(
            self::EMAIL
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetPassword::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->email()->shouldReturn(self::EMAIL);
    }
}
