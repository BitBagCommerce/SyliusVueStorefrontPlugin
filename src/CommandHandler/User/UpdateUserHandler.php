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

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateUserHandler implements MessageHandlerInterface
{
    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(UpdateUser $command): void
    {
        $customer = $this->customerRepository->findOneBy(['id' => $command->customer()->getId()]);

        $customer->setFirstName($command->customer()->getFirstName());
        $customer->setLastName($command->customer()->getLastName());

        $this->customerRepository->add($customer);
    }
}
