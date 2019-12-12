<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Processor\RequestProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdateUserAction
{
    /** @var RequestProcessorInterface */
    private $updateUserRequestProcessor;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var UserProfileViewFactoryInterface */
    private $userProfileViewFactory;

    public function __construct(
        RequestProcessorInterface $updateUserRequestProcessor,
        MessageBusInterface $bus,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        CustomerRepositoryInterface $loggedInUserProvider
    ) {
        $this->updateUserRequestProcessor = $updateUserRequestProcessor;
        $this->bus = $bus;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->customerRepository = $loggedInUserProvider;
        $this->userProfileViewFactory = $userProfileViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $validationResults = $this->updateUserRequestProcessor->validate($request);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        /** @var UpdateUser $updateUserCommand */
        $updateUserCommand = $this->updateUserRequestProcessor->getCommand($request);

        $this->bus->dispatch($updateUserCommand);

        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy(['id' => $updateUserCommand->customer()->id]);

        return $this->viewHandler->handle(View::create(
            $this->userProfileViewFactory->create($customer),
            Response::HTTP_OK
        ));
    }
}
