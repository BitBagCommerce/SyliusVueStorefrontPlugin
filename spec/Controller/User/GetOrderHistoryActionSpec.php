<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\GetOrderHistoryAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\OrderHistoryViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOrderHistoryActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetOrderHistoryAction::class);
    }

    function let(
        ViewHandlerInterface $viewHandler,
        OrderHistoryViewFactoryInterface $orderHistoryViewFactory
    ): void {
        $this->beConstructedWith(
            $viewHandler,
            $orderHistoryViewFactory
        );
    }

    function it_gets_order_history_action(
        ViewHandlerInterface $viewHandler,
        OrderHistoryViewFactoryInterface $orderHistoryViewFactory
    ): void {
        $orderHistoryViewFactory->create()->willReturn(new OrderHistoryView());
        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke(new Request());
    }
}
