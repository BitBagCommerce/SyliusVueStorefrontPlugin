<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationErrorViewFactorySpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(ValidationErrorView::class);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ValidationErrorViewFactory::class);
    }

    function it_creates_validation_error_view(ConstraintViolationListInterface $validationResults): void
    {
        $this->create($validationResults)->shouldReturnAnInstanceOf(ValidationErrorView::class);
    }
}
