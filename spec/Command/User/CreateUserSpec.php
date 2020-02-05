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

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\NewCustomer;
use PhpSpec\ObjectBehavior;

final class CreateUserSpec extends ObjectBehavior
{
    function let(): void
    {
        $customer = new NewCustomer();

        $this->beConstructedWith($customer, 'password');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateUser::class);
    }

    function it_allows_to_access_properties_via_getters(): void
    {
        $this->customer()->shouldReturnAnInstanceOf(NewCustomer::class);
        $this->password()->shouldReturn('password');
    }
}
