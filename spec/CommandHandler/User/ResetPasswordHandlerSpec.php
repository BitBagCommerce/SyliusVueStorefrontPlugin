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

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use BitBag\SyliusVueStorefrontPlugin\CommandHandler\User\ResetPasswordHandler;
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
        $this->beConstructedWith($userRepository, $tokenGenerator, $sender, $channelProvider);
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
        $user->setPasswordRequestedAt(Argument::type(\DateTime::class))->shouldBeCalled();

        $user->getPasswordResetToken()->willReturn('token123');

        $channelProvider->provide()->willReturn($channel);

        $sender->send(
            'api_reset_password_token',
            ['shop@example.com'],
            ['user' => $user, 'channel' => $channel]
        )->shouldBeCalled();

        $this->__invoke($resetPassword);
    }
}
