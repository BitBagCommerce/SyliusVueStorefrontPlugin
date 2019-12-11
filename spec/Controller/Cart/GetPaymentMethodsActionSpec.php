<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\GetPaymentMethodsAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\PaymentMethodViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\ValidationErrorViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetPaymentMethodsRequest;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\PaymentMethodView;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GetPaymentMethodsActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetPaymentMethodsAction::class);
    }

    function let(
        ValidatorInterface $validator,
        ViewHandlerInterface $viewHandler,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ChannelProviderInterface $channelProvider,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        PaymentMethodViewFactoryInterface $paymentMethodViewFactory
    ): void {
        $this->beConstructedWith(
            $validator,
            $viewHandler,
            $validationErrorViewFactory,
            $genericSuccessViewFactory,
            $channelProvider,
            $paymentMethodRepository,
            $paymentMethodViewFactory
        );
    }

    function it_gets_payment_methods(
        ValidatorInterface $validator,
        ConstraintViolationListInterface $violationList,
        PaymentMethodInterface $paymentMethod,
        ChannelProviderInterface $channelProvider,
        ChannelInterface $channel,
        PaymentMethodRepositoryInterface $paymentMethodRepository,
        PaymentMethodViewFactoryInterface $paymentMethodViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request(
            [
                'token' => 'token',
                'cartId' => '12345',
            ]
        );

        $getPaymentMethodsRequest = new GetPaymentMethodsRequest($request);

        $validator->validate($getPaymentMethodsRequest)->willReturn($violationList);

        $channelProvider->provide()->willReturn($channel);

        $paymentMethodRepository->findEnabledForChannel($channel)->willReturn(
            [
                $paymentMethod,
                $paymentMethod,
            ]
        );

        $paymentMethodViewFactory->createList(
            [
                $paymentMethod,
                $paymentMethod,
            ]
        )->willReturn(
            [
                new PaymentMethodView(),
                new PaymentMethodView(),
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

        $getPaymentMethodsRequest = new GetPaymentMethodsRequest($request);

        $violationList = new ConstraintViolationList([$constraintViolation->getWrappedObject()]);

        $validator->validate($getPaymentMethodsRequest)->willReturn($violationList);

        $validationErrorViewFactory->create($violationList)->willReturn(new ValidationErrorView());

        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
