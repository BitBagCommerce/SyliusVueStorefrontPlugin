<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Processor;

use BitBag\SyliusVueStorefrontPlugin\Request\User\CreateUserRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestProcessor
{
    private const FORMAT_JSON = 'json';

    /** @var ValidatorInterface */
    private $validator;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function validate(Request $httpRequest): ConstraintViolationListInterface
    {
        return $this->validator->validate($this->transformHttpRequest($httpRequest));
    }

    public function getCommand(Request $httpRequest, string $className): object
    {
        return $this->transformHttpRequest($httpRequest)->getCommand();
    }

    private function transformHttpRequest(Request $httpRequest): object
    {
        $requestBody = $this->serializer->decode($httpRequest->getContent(), self::FORMAT_JSON);
        return $this->serializer->denormalize(
            \array_merge($requestBody, $httpRequest->attributes->all(), $httpRequest->query->all()),
            CreateUserRequest::class
        );
    }
}
