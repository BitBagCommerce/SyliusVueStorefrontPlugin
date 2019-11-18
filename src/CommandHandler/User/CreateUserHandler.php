<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class CreateUserHandler implements MessageHandlerInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var FactoryInterface */
    private $userFactory;

    /** @var FactoryInterface */
    private $customerFactory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ChannelRepositoryInterface $channelRepository,
        FactoryInterface $userFactory,
        FactoryInterface $customerFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->channelRepository = $channelRepository;
        $this->userFactory = $userFactory;
        $this->customerFactory = $customerFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateUser $command): void
    {
        $this->assertEmailIsNotTaken($command->customer()->email());
//         Move it to controller, out of handler
//        $this->assertChannelExists($command->channelCode());
    }

    private function assertEmailIsNotTaken(string $email): void
    {
        Assert::null($this->userRepository->findOneByEmail($email), 'User with given email already exists.');
    }

    private function assertChannelExists(string $channelCode): void
    {
        Assert::notNull($this->channelRepository->findOneByCode($channelCode), 'Channel does not exist.');
    }
}
