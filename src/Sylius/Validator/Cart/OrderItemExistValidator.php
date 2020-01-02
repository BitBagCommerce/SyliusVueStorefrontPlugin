<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Cart;

use Doctrine\Common\Collections\Criteria;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Repository\OrderItemRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class OrderItemExistValidator extends ConstraintValidator
{
    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    public function __construct(OrderItemRepositoryInterface $orderItemRepository, OrderRepositoryInterface $cartRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->cartRepository = $cartRepository;
    }

    public function validate($request, Constraint $constraint)
    {
        $cart = $this->cartRepository->findOneBy(['tokenValue' => $request->cartId, 'state' => OrderInterface::STATE_CART]);

        $orderItem = $cart->getItems()->matching(
            Criteria::create()
                ->where(
                    Criteria::expr()->eq('id', $request->cartItem->item_id)
                )
        )->first();

        if (false === $orderItem) {
            $this->context->addViolation($constraint->message);
        }
    }
}
