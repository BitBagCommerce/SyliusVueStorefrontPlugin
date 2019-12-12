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

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface RequestProcessorInterface
{
    public const FORMAT_JSON = 'json';

    public function validate(Request $httpRequest): ConstraintViolationListInterface;

    public function getCommand(Request $httpRequest): CommandInterface;

    public function getQuery(Request $httpRequest): QueryInterface;
}
