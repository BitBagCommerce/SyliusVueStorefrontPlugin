<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\CreateUserHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\NewCustomer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

class CreateUserHandlerSpec extends ObjectBehavior
{
    public function let(
        UserRepositoryInterface $userRepository,
        FactoryInterface $userFactory,
        FactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository
    ): void
    {
        $this->beConstructedWith(
            $userRepository,
            $userFactory,
            $customerFactory,
            $customerRepository
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateUserHandler::class);
    }

    public function it_creates_user(
        CustomerInterface $customer,
        FactoryInterface $customerFactory
    ): void
    {
        $newCustomer = NewCustomer::createFromArray([
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska'
        ]);
        $password = 'example-password';
        $command = new CreateUser($newCustomer, $password);

        $customerFactory->createNew()->willReturn($customer);

        $this->__invoke($command);
    }
}
