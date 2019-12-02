<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use PhpSpec\ObjectBehavior;

class ChangePasswordSpec extends ObjectBehavior
{
    const NEW_PASSWORD = 'sylius';

    public function let(): void
    {
        $this->beConstructedWith(
            self::NEW_PASSWORD
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangePassword::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->newPassword()->shouldReturn(self::NEW_PASSWORD);
    }
}
