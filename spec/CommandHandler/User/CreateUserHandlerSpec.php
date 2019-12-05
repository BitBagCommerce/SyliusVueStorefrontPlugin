<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\CreateUserHandler;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\NewCustomer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
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
        FactoryInterface $customerFactory,
        FactoryInterface $userFactory,
        ShopUserInterface $user,
        UserRepositoryInterface $userRepository
    ): void
    {
        $newCustomer = NewCustomer::createFromArray([
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska'
        ]);

        $userRepository->findOneByEmail($newCustomer->email())->willReturn(null);

        $password = 'example-password';
        $command = new CreateUser($newCustomer, $password);

        $customerFactory->createNew()->willReturn($customer);
        $customer->setFirstName($command->customer()->firstName())->shouldBeCalled();
        $customer->setLastName($command->customer()->lastName())->shouldBeCalled();
        $customer->setEmail($command->customer()->email())->shouldBeCalled();

        $userFactory->createNew()->willReturn($user);
        $user->setPlainPassword($command->password())->shouldBeCalled();
        $user->setCustomer($customer)->shouldBeCalled();
        $user->setUsername($command->customer()->email())->shouldBeCalled();
        $user->setUsernameCanonical($command->customer()->email())->shouldBeCalled();
        $user->setEnabled(true)->shouldBeCalled();
        $userRepository->add($user)->shouldBeCalled();

        $this->__invoke($command);
    }
}
