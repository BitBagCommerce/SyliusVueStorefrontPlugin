<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationErrorViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ValidationErrorViewFactory::class);
    }

    function it_creates_validation_error_view(ConstraintViolationListInterface $validationResults): void
    {
        $this->create($validationResults)->shouldReturnAnInstanceOf(ValidationErrorView::class);
    }
}
