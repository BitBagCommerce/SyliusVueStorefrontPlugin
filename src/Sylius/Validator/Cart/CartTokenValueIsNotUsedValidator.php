<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Cart;

use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CartTokenValueIsNotUsedValidator extends ConstraintValidator
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function validate($cartId, Constraint $constraint): void
    {
        if (null !== $this->orderRepository->findOneBy(['tokenValue' => $cartId])) {
            $this->context->addViolation($constraint->message);
        }
    }
}
