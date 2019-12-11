<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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
