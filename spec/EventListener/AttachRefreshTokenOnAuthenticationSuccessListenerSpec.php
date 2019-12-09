<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\EventListener;

use BitBag\SyliusVueStorefrontPlugin\EventListener\AttachRefreshTokenOnAuthenticationSuccessListener;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Request\RequestRefreshToken;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AttachRefreshTokenOnAuthenticationSuccessListenerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(AttachRefreshTokenOnAuthenticationSuccessListener::class);
    }

    function it_returns_when_no_user_passed(
        UserInterface $user,
        RequestStack $requestStack
    ): void {
        /** @var AuthenticationSuccessEvent $event */
        $event = new AuthenticationSuccessEvent([], $user->getWrappedObject(), new Response());
        $requestStack->getCurrentRequest()->willReturn(new Request());

        throw new SkippingException('todo');

        $this->attachRefreshToken($event);
    }

    function it_attaches_existing_single_use_refresh_token_on_authentication_success_listener(
        RefreshTokenManagerInterface $refreshTokenManager,
        ValidatorInterface $validator,
        RequestStack $requestStack,
        UserInterface $user,
        RefreshTokenInterface $refreshToken,
        PropertyAccessorInterface $accessor,
        ConstraintViolationInterface $constraintViolation
    ): void {
        $this->beConstructedWith(
            $refreshTokenManager,
            1,
            $validator,
            $requestStack,
            'username',
            true
        );

        $request = new Request([
            'refreshToken' => 'token'
        ]);

        /** @var AuthenticationSuccessEvent $event */
        $event = new AuthenticationSuccessEvent([], $user->getWrappedObject(), new Response());
        $requestStack->getCurrentRequest()->willReturn($request);

        $refreshTokenString = RequestRefreshToken::getRefreshToken($request, 'refreshToken');

        $refreshTokenManager->get($refreshTokenString)->willReturn($refreshToken);
        $refreshTokenManager->delete($refreshToken)->shouldBeCalled();

        $refreshTokenManager->create()->willReturn($refreshToken);

        $accessor->getValue($user, 'username')->willReturn('example-username');

        $refreshToken->setUsername(Argument::any())->shouldBeCalled();
        $refreshToken->setRefreshToken()->shouldBeCalled();
        $refreshToken->setValid(Argument::any())->shouldBeCalled();

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($refreshToken)->willReturn($violationList);
        $refreshTokenManager->save($refreshToken)->shouldBeCalled();
        $refreshToken->getRefreshToken()->shouldBeCalled();

        $this->attachRefreshToken($event);
    }
}
