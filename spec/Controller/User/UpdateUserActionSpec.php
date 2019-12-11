<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\UpdateUserAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\User\UpdateUserRequest;
use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateUserActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateUserAction::class);
    }

    function let(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        CustomerRepositoryInterface $loggedInUserProvider
    ): void {
        $this->beConstructedWith(
            $bus,
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $userProfileViewFactory,
            $loggedInUserProvider
        );
    }

    function it_updates_user(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        MessageBusInterface $bus,
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request([], [
            'customer' => [
                'id' => 1,
                'group_id' => 2,
                'default_billing' => 'billing',
                'default_shipping' => 'shipping',
                'created_at' => 'yesterday',
                'updated_at' => 'yesterday',
                'created_in' => 'city',
                'email' => 'shop@example.com',
                'firstname' => 'Katarzyna',
                'lastname' => 'Nosowska',
                'store_id' => 1,
                'website_id' => 2,
                'addresses' => [
                    1 => [
                        'id' => 1,
                        'customer_id' => 1,
                        'region' => [
                            'region_code' => 'example-code',
                            'region' => 'example-region',
                            'region_id' => 1,
                        ],
                        'region_id' => 1,
                        'country_id' => 'country',
                        'street' => 'example-street',
                        'company' => 'example',
                        'telephone' => '987 654 321',
                        'postcode' => '12345',
                        'city' => 'example-city',
                        'firstname' => 'Katarzyna',
                        'lastname' => 'Nosowska',
                        'vat_id' => 'example-id',
                    ],
                    2 => [
                        'id' => 1,
                        'customer_id' => 1,
                        'region' => [
                            'region_code' => 'example-code',
                            'region' => 'example-region',
                            'region_id' => 1,
                        ],
                        'region_id' => 1,
                        'country_id' => 'country',
                        'street' => 'example-street',
                        'company' => 'example',
                        'telephone' => '987 654 321',
                        'postcode' => '12345',
                        'city' => 'example-city',
                        'firstname' => 'Katarzyna',
                        'lastname' => 'Nosowska',
                        'vat_id' => 'example-id',
                    ],
                ],
                'disable_auto_group_change' => 0,
            ]
        ]);

        $updateUserRequest = new UpdateUserRequest($request);

        $validator->validate($updateUserRequest)->willReturn($violationList);
        $envelope = new Envelope($updateUserRequest->command(), []);
        $bus->dispatch($updateUserRequest->command())->willReturn($envelope);

        $customerRepository->findOneBy(['id' => $updateUserRequest->command()->customer()->id()])->willReturn($customer);

        throw new SkippingException('$userProfileViewFactory->create() problem');

        $userProfileViewFactory->create($customer->getWrappedObject())->willReturn(new UserProfileView());

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
            'customer' => [
                'id' => 1,
                'group_id' => 2,
                'default_billing' => 'billing',
                'default_shipping' => 'shipping',
                'created_at' => 'yesterday',
                'updated_at' => 'yesterday',
                'created_in' => 'city',
                'email' => 'shop@example.com',
                'firstname' => 'Katarzyna',
                'lastname' => 'Nosowska',
                'store_id' => 1,
                'website_id' => 2,
                'addresses' => [
                    1 => [
                        'id' => 1,
                        'customer_id' => 1,
                        'region' => [
                            'region_code' => 'example-code',
                            'region' => 'example-region',
                            'region_id' => 1,
                        ],
                        'region_id' => 1,
                        'country_id' => 'country',
                        'street' => 'example-street',
                        'company' => 'example',
                        'telephone' => '987 654 321',
                        'postcode' => '12345',
                        'city' => 'example-city',
                        'firstname' => 'Katarzyna',
                        'lastname' => 'Nosowska',
                        'vat_id' => 'example-id',
                    ],
                    2 => [
                        'id' => 1,
                        'customer_id' => 1,
                        'region' => [
                            'region_code' => 'example-code',
                            'region' => 'example-region',
                            'region_id' => 1,
                        ],
                        'region_id' => 1,
                        'country_id' => 'country',
                        'street' => 'example-street',
                        'company' => 'example',
                        'telephone' => '987 654 321',
                        'postcode' => '12345',
                        'city' => 'example-city',
                        'firstname' => 'Katarzyna',
                        'lastname' => 'Nosowska',
                        'vat_id' => 'example-id',
                    ],
                ],
                'disable_auto_group_change' => 0,
            ]
        ]);

        $updateUserRequest = new UpdateUserRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($updateUserRequest)->willReturn($violationList);

        $envelope = new Envelope($updateUserRequest->command(), []);
        $bus->dispatch($updateUserRequest->command())->willReturn($envelope);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
