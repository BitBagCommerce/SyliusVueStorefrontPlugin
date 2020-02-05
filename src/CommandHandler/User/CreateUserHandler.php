<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class CreateUserHandler implements MessageHandlerInterface
{
    /** @var FactoryInterface */
    private $customerFactory;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var FactoryInterface */
    private $userFactory;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var AddressFactoryInterface */
    private $addressFactory;

    public function __construct(
        FactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        FactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        AddressFactoryInterface $addressFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->addressFactory = $addressFactory;
    }

    public function __invoke(CreateUser $command): void
    {
        $this->assertEmailIsNotTaken($command->customer()->email);

        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();

        $customer->setFirstName($command->customer()->firstname);
        $customer->setLastName($command->customer()->lastname);
        $customer->setEmail($command->customer()->email);

        $this->customerRepository->add($customer);

        /** @var ShopUserInterface $user */
        $user = $this->userFactory->createNew();
        $user->setPlainPassword($command->password());
        $user->setCustomer($customer);
        $user->setUsername($command->customer()->email);
        $user->setUsernameCanonical($command->customer()->email);
        $user->setEnabled(true);

        $this->userRepository->add($user);

        $address = $this->addressFactory->createForCustomer($customer);
        $address->setFirstName($command->customer()->firstname);
        $address->setLastName($command->customer()->lastname);
        $address->setStreet('');
        $address->setCountryCode('');
        $address->setPostcode('');
        $address->setCity('');

        $customer->setDefaultAddress($address);
    }

    private function assertEmailIsNotTaken(string $email): void
    {
        Assert::null($this->userRepository->findOneByEmail($email), 'User with given email already exists.');
    }
}
