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
use BitBag\SyliusVueStorefrontPlugin\Response\VueStorefrontResponse;
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

    public function __construct(MessageBusInterface $bus, ValidatorInterface $validator)
    {

        $this->bus = $bus;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): Response
    {
        $createCartRequest = new CreateCartRequest($request);

        $validation = $this->validator->validate($createCartRequest);

        $createCartCommand = $createCartRequest->getCommand();

        $this->bus->dispatch($createCartCommand);

        if (null === $request) {
            return VueStorefrontResponse::error('Invalid request');
            //            throw new BadRequestHttpException();
        }


        return VueStorefrontResponse::success($payload);
    }
}
