<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\CreateCartAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
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

final class CreateCartActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateCartAction::class);
    }

    function let(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ): void {
        $this->beConstructedWith(
            $bus,
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $genericSuccessViewFactory
        );
    }

    function it_creates_cart(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        MessageBusInterface $bus,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([
            'token' => 'token',
        ]);

        $createCartRequest = new CreateCartRequest($request);

        $validator->validate($createCartRequest)->willReturn($violationList);

        $envelope = new Envelope($createCartRequest->getCommand(), []);
        $bus->dispatch(Argument::any())->willReturn($envelope);

        $genericSuccessViewFactory->create(Argument::any())->willReturn(new GenericSuccessView());

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
        $request = new Request([
            'token' => 'token',
        ]);

        $createCartRequest = new CreateCartRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($createCartRequest)->willReturn($violationList);

        $envelope = new Envelope($createCartRequest->getCommand(), []);
        $bus->dispatch(Argument::any())->willReturn($envelope);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
