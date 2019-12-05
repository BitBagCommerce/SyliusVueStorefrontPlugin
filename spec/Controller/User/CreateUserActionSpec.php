<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\CreateUserAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\User\CreateUserRequest;
use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateUserAction::class);
    }

    function let(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        CustomerRepositoryInterface $customerRepository
    ): void
    {
        $this->beConstructedWith(
            $bus,
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $userProfileViewFactory,
            $customerRepository
        );
    }

    function it_creates_user(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        ConstraintViolationInterface $constraintViolation,
        MessageBusInterface $bus,
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        ViewHandlerInterface $viewHandler
    ): void
    {
        $request = new Request([], [
            'customer' => [
                'email' => 'shop@example.com',
                'firstname' => 'Katarzyna',
                'lastname' => 'Nosowska',
            ],
            'password' => 'example-password',
        ]);

        $createUserRequest = new CreateUserRequest($request);

        $validator->validate($createUserRequest)->willReturn($violationList);
        $envelope = new Envelope($createUserRequest->getCommand(), []);
        $bus->dispatch($createUserRequest->getCommand())->willReturn($envelope);

        $customerRepository->findOneBy(['email' => 'shop@example.com'])->willReturn($customer);

        $userProfileViewFactory->create($customer)->willReturn(new UserProfileView());

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
            'customer' => [
                'email' => 'shop@example.com',
                'firstname' => 'Katarzyna',
                'lastname' => 'Nosowska',
            ],
            'password' => 'example-password',
        ]);

        $createUserRequest = new CreateUserRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($createUserRequest)->willReturn($violationList);

        $envelope = new Envelope($createUserRequest->getCommand(), []);
        $bus->dispatch($createUserRequest->getCommand())->willReturn($envelope);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
