<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\CreateUser;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessor;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateUserAction
{
    /** @var RequestProcessorInterface */
    private $createUserRequestProcessor;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var GenericSuccessViewFactoryInterface */
    private $genericSuccessViewFactory;

    /** @var UserProfileViewFactoryInterface */
    private $userProfileViewFactory;

    public function __construct(
        RequestProcessorInterface $createUserRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        CustomerRepositoryInterface $customerRepository,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        UserProfileViewFactoryInterface $userProfileViewFactory
    ) {
        $this->createUserRequestProcessor = $createUserRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->customerRepository = $customerRepository;
        $this->genericSuccessViewFactory = $genericSuccessViewFactory;
        $this->userProfileViewFactory = $userProfileViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->createUserRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var CreateUser $createUserCommand */
        $createUserCommand = $this->createUserRequestProcessor->getCommand($request);

        $this->bus->dispatch($createUserCommand);

        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy(['email' => $createUserCommand->customer()->email]);

        return $this->viewHandler->handle(View::create(
            $this->genericSuccessViewFactory->create(
                $this->userProfileViewFactory->create($customer)
            ),
            Response::HTTP_OK
        ));
    }
}
