<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Query\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\PaginationParameters;
use BitBag\SyliusVueStorefrontPlugin\Query\User\GetOrderHistory;
use PhpSpec\ObjectBehavior;

final class GetOrderHistorySpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('token', new PaginationParameters((string) 21, (string) 1));
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetOrderHistory::class);
    }

    function it_allows_to_access_token_via_getter(): void
    {
        $this->token()->shouldReturn('token');
    }
}
