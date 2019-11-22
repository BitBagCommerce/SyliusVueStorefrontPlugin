<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */


declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationErrorViewFactory implements ValidationErrorViewFactoryInterface
{
    public function create(ConstraintViolationListInterface $validationResults): ValidationErrorView
    {
        $errorMessage = new ValidationErrorView();
        $errorMessage->code = Response::HTTP_INTERNAL_SERVER_ERROR;

        $message = [];

        /** @var ConstraintViolationInterface $result */
        foreach ($validationResults as $result) {
            $message[] = $result->getMessage();
        }

        $errorMessage->result = \implode(', ', $message);

        return $errorMessage;
    }
}
