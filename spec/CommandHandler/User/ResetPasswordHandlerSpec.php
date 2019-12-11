<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\CommandHandler\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\ResetPasswordHandler;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Mailer\Emails;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;

final class ResetPasswordHandlerSpec extends ObjectBehavior
{
    function let(
        UserRepositoryInterface $userRepository,
        GeneratorInterface $tokenGenerator,
        SenderInterface $sender,
        ChannelProviderInterface $channelProvider
    ): void {
        $this->beConstructedWith(
            $userRepository,
            $tokenGenerator,
            $sender,
            $channelProvider
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetPasswordHandler::class);
    }

    function it_resets_password(
        UserRepositoryInterface $userRepository,
        ShopUserInterface $user,
        GeneratorInterface $tokenGenerator,
        SenderInterface $sender,
        ChannelProviderInterface $channelProvider,
        ChannelInterface $channel
    ): void {
        $resetPassword = new ResetPassword('shop@example.com');

        $userRepository->findOneByEmail('shop@example.com')->willReturn($user);

        $tokenGenerator->generate()->willReturn('token123');

        $user->setPasswordResetToken('token123')->shouldBeCalled();
        $user->setPasswordRequestedAt(Argument::any())->shouldBeCalled();

        $user->getPasswordResetToken()->willReturn('token123');

        $channelProvider->provide()->willReturn($channel);

        $sender->send(
            Emails::EMAIL_RESET_PASSWORD_TOKEN,
            ['shop@example.com'],
            ['user' => $user, 'channelCode' => $channel]
        )->shouldBeCalled();

        $this->__invoke($resetPassword);
    }
}
