<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use PhpSpec\ObjectBehavior;

/**
 * @todo SPEC
 * Class UpdateUserSpec
 * @package spec\BitBag\SyliusVueStorefrontPlugin\Command\User
 */
class UpdateUserSpec extends ObjectBehavior
{
    private const PASSWORD = 'sylius';

    /** @var User */
    private $customer;

    public function let(): void
    {
        $this->beConstructedWith(
            $this->customer,
            self::PASSWORD
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateUser::class);
    }
}
