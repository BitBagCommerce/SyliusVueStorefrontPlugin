<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Response\Payload;
use BitBag\SyliusVueStorefrontPlugin\Response\VueStorefrontResponse;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateCartAction
{
    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        MessageBusInterface $bus,
        ValidatorInterface $validator
    ) {
        $this->bus = $bus;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): Response
    {
        if (null === $request) {
            return VueStorefrontResponse::error('Invalid request');
        }
        $cartId = Uuid::uuid4();
        $createCartRequest = new CreateCartRequest($request, $cartId);

        $validation = $this->validator->validate($createCartRequest);

        $createCartCommand = $createCartRequest->getCommand();

        $this->bus->dispatch($createCartCommand);

        $payload = new Payload($createCartCommand->cartId());

        return VueStorefrontResponse::success($payload);
    }
}
