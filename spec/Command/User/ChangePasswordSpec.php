<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ChangePassword;
use PhpSpec\ObjectBehavior;

final class ChangePasswordSpec extends ObjectBehavior
{
    private const NEW_PASSWORD = 'sylius';

    public function let(): void
    {
        $this->beConstructedWith(
            self::NEW_PASSWORD
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangePassword::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->newPassword()->shouldReturn(self::NEW_PASSWORD);
    }
}
