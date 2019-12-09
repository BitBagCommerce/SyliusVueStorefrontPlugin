<?php

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

    public function let(): void
    {
        $this->customer = $this->getCustomerMock();

        $this->beConstructedWith(
            $this->customer,
            self::PASSWORD
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateUser::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->customer()->shouldReturn($this->customer);
        $this->password()->shouldReturn(self::PASSWORD);
    }

    private function getCustomerMock(): NewCustomer
    {
        $customer = NewCustomer::createFromArray([
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska'
        ]);

        return $customer;
    }
}
