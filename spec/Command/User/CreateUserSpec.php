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
    private const PASSWORD = 'sylius';

    /** @var NewCustomer */
    private $customer;

    function let(): void
    {
        $this->customer = $this->getCustomerMock();

        $this->beConstructedWith(
            $this->customer,
            self::PASSWORD
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateUser::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->customer()->shouldReturn($this->customer);
        $this->password()->shouldReturn(self::PASSWORD);
    }

    private function getCustomerMock(): NewCustomer
    {
        return NewCustomer::createFromArray([
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska',
        ]);
    }
}
