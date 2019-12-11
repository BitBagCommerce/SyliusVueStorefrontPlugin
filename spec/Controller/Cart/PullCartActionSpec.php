<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\PullCartAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CartItemViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\PullCartRequest;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PullCartActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PullCartAction::class);
    }

    function let(
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        OrderRepositoryInterface $orderRepository,
        CartItemViewFactoryInterface $cartItemViewFactory
    ): void {
        $this->beConstructedWith(
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $genericSuccessViewFactory,
            $orderRepository,
            $cartItemViewFactory
        );
    }

    function it_pulls_cart(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        OrderRepositoryInterface $orderRepository,
        OrderInterface $cart,
        OrderItemInterface $cartItem,
        CartItemViewFactoryInterface $cartItemViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request(
            [
                'token' => 'token',
                'cartId' => '12345',
            ]
        );

        $pullCartRequest = new PullCartRequest($request);

        $validator->validate($pullCartRequest)->willReturn($violationList);

        $orderRepository->findOneBy(
            [
                'tokenValue' => '12345',
                'state' => 'cart',
            ]
        )->willReturn($cart);

        $cart->getItems()->willReturn(new ArrayCollection(
            [
                $cartItem,
                $cartItem
            ]
        ));

        $cartItemViewFactory->createList(Argument::any())->willReturn(
            [
                new CartItemView(),
                new CartItemView(),
            ]
        );

        $genericSuccessViewFactory->create(Argument::any())->willReturn(new GenericSuccessView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }

    function it_returns_validation_error(
        ValidatorInterface $validator,
        ConstraintViolationInterface $constraintViolation,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request(
            [
                'token' => 'token',
                'cartId' => '12345',
            ]
        );

        $pullCartRequest = new PullCartRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($pullCartRequest)->willReturn($violationList);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
