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

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;
use PhpSpec\ObjectBehavior;

final class UpdateUserSpec extends ObjectBehavior
{
    public function let(): void
    {
        $customer = new ExistingUser();

        $this->beConstructedWith($customer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateUser::class);
    }

    function it_allows_to_access_customer_via_getter(): void
    {
        $this->customer()->shouldReturnAnInstanceOf(ExistingUser::class);
    }
}
