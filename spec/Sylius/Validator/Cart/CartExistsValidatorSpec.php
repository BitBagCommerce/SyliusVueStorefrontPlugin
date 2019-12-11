<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Cart;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Cart\CartExistsValidator;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContext;

final class CartExistsValidatorSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CartExistsValidator::class);
    }

    function let(OrderRepositoryInterface $orderRepository): void
    {
        $this->beConstructedWith($orderRepository);
    }

    function it_validates_when_cart_exists(
        OrderRepositoryInterface $orderRepository,
        Constraint $constraint
    ): void {
        $orderRepository->findOneBy(['tokenValue' => 1, 'state' => 'cart'])->willReturn(['something']);

        $this->validate(1, $constraint);
    }

    function it_validates_when_cart_not_exists(
        OrderRepositoryInterface $orderRepository,
        Constraint $constraint,
        ExecutionContext $context
    ): void {
        $orderRepository->findOneBy(['tokenValue' => 1, 'state' => 'cart'])->willReturn(null);

        throw new SkippingException('$this->context and $constraint->message problems');
        $this->validate(1, $constraint);
    }
}
