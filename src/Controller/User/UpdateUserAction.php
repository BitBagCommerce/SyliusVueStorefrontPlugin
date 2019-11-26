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

use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\User\UpdateUserRequest;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProvider;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateUserAction
{
    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ValidationErrorViewFactoryInterface */
    private $validationErrorViewFactory;

    /** @var UserProfileViewFactoryInterface */
    private $userProfileViewFactory;

    /** @var LoggedInShopUserProvider */
    private $loggedInUserProvider;

    public function __construct(
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        LoggedInShopUserProvider $loggedInUserProvider
    ) {
        $this->bus = $bus;
        $this->validator = $validator;
        $this->viewHandler = $viewHandler;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->userProfileViewFactory = $userProfileViewFactory;
        $this->loggedInUserProvider = $loggedInUserProvider;
    }

    public function __invoke(Request $request): Response
    {
        $updateUserRequest = UpdateUserRequest::fromHttpRequest($request);

        $validationResults = $this->validator->validate($updateUserRequest);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(View::create(
                $this->validationErrorViewFactory->create($validationResults),
                Response::HTTP_BAD_REQUEST
            ));
        }

        $this->bus->dispatch($updateUserRequest->command());

        new Response('dsfdsf');
//
//        return $this->viewHandler->handle(View::create(
////            $this->userProfileViewFactory->create($customer),
////            Response::HTTP_OK
//        ));
    }
}
