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

use BitBag\SyliusVueStorefrontPlugin\Command\User\ResetPassword;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Mailer\Emails;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProvider;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class ResetPasswordHandler implements MessageHandlerInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var GeneratorInterface */
    private $tokenGenerator;

    /** @var SenderInterface */
    private $sender;

    /** @var ChannelProvider */
    private $channelProvider;

    public function __construct(
        UserRepositoryInterface $userRepository,
        GeneratorInterface $tokenGenerator,
        SenderInterface $sender,
        ChannelProvider $channelProvider
    ) {
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->sender = $sender;
        $this->channelProvider = $channelProvider;
    }

    public function __invoke(ResetPassword $resetPassword): void
    {
        $email = $resetPassword->email();

        /** @var ShopUserInterface $user */
        $user = $this->userRepository->findOneByEmail($email);

        Assert::notNull($user, sprintf('User with %s email has not been found.', $email));

        $user->setPasswordResetToken($this->tokenGenerator->generate());
        $user->setPasswordRequestedAt(new \DateTime());

        Assert::notNull($user->getPasswordResetToken(), sprintf('User with %s email has not verification token defined.', $email));

        $this->sender->send(
            Emails::EMAIL_RESET_PASSWORD_TOKEN,
            [$email],
            ['user' => $user, 'channelCode' => $this->channelProvider->provide()]
        );
    }
}
