<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\ResetPasswordAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\ApplyCouponRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\ResetPasswordRequest;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ResetPasswordActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetPasswordAction::class);
    }

    function let(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory
    ): void {
        $this->beConstructedWith(
            $bus,
            $validator,
            $viewHandler,
            $validationErrorViewFactory
        );
    }

    function it_resets_password(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        ConstraintViolationInterface $constraintViolation,
        MessageBusInterface $bus,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [
            'email' => 'shop@example.com'
        ]);

        $resetPasswordRequest = new ResetPasswordRequest($request);

        $validator->validate($resetPasswordRequest)->willReturn($violationList);
        $envelope = new Envelope($resetPasswordRequest->getCommand(), []);
        $bus->dispatch($resetPasswordRequest->getCommand())->willReturn($envelope);

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }

    function it_returns_validation_error(
        ValidatorInterface $validator,
        ConstraintViolationInterface $constraintViolation,
        MessageBusInterface $bus,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [
            'email' => 'shop@example.com'
        ]);

        $resetPasswordRequest = new ResetPasswordRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($resetPasswordRequest)->willReturn($violationList);

        $envelope = new Envelope($resetPasswordRequest->getCommand(), []);
        $bus->dispatch($resetPasswordRequest->getCommand())->willReturn($envelope);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
