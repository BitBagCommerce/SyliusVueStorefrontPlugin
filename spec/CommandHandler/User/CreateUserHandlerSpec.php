<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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

final class CreateUserHandlerSpec extends ObjectBehavior
{
    public function let(
        UserRepositoryInterface $userRepository,
        FactoryInterface $userFactory,
        FactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository
    ): void {
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
    ): void {
        $newCustomer = NewCustomer::createFromArray([
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska',
        ]);

        $userRepository->findOneByEmail($newCustomer->email())->willReturn(null);

        $command = new CreateUser($newCustomer, 'example-password');

        $customerFactory->createNew()->willReturn($customer);
        $customer->setFirstName('Katarzyna')->shouldBeCalled();
        $customer->setLastName('Nosowska')->shouldBeCalled();
        $customer->setEmail('shop@example.com')->shouldBeCalled();

        $userFactory->createNew()->willReturn($user);
        $user->setPlainPassword('example-password')->shouldBeCalled();
        $user->setCustomer($customer)->shouldBeCalled();
        $user->setUsername('shop@example.com')->shouldBeCalled();
        $user->setUsernameCanonical('shop@example.com')->shouldBeCalled();
        $user->setEnabled(true)->shouldBeCalled();

        $userRepository->add($user)->shouldBeCalled();

        $this->__invoke($command);
    }
}
