<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\ChangePasswordAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\User\ChangePasswordRequest;
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

class ChangePasswordActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangePasswordAction::class);
    }

    function let(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory
    ): void
    {
        $this->beConstructedWith(
            $bus,
            $validator,
            $viewHandler,
            $validationErrorViewFactory
        );
    }

    function it_changes_password(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        ConstraintViolationInterface $constraintViolation,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler
    ): void
    {
        $request = new Request([], [
            'currentPassword' => 'old-password',
            'newPassword' => 'brand-new-password'
        ]);

        $changePasswordRequest = new ChangePasswordRequest($request);

        $validator->validate($changePasswordRequest)->willReturn($violationList);
        $envelope = new Envelope($changePasswordRequest->getCommand(), []);
        $bus->dispatch($changePasswordRequest->getCommand())->willReturn($envelope);

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }

    function it_returns_validation_error(
        ValidatorInterface $validator,
        ConstraintViolationInterface $constraintViolation,
        MessageBusInterface $bus,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        ViewHandlerInterface $viewHandler
    ): void
    {
        $request = new Request([], [
            'currentPassword' => 'old-password',
            'newPassword' => 'brand-new-password'
        ]);

        $changePasswordRequest = new ChangePasswordRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($changePasswordRequest)->willReturn($violationList);

        $envelope = new Envelope($changePasswordRequest->getCommand(), []);
        $bus->dispatch($changePasswordRequest->getCommand())->willReturn($envelope);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
