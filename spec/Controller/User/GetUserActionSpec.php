<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use BitBag\SyliusVueStorefrontPlugin\Controller\User\GetUserAction;
use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Factory\User\UserProfileViewFactoryInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\LoggedInShopUserProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use FOS\RestBundle\View\ViewHandlerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetUserActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetUserAction::class);
    }

    function let(
        ViewHandlerInterface $viewHandler,
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory
    ): void {
        $this->beConstructedWith(
            $viewHandler,
            $loggedInShopUserProvider,
            $userProfileViewFactory,
            $genericSuccessViewFactory
        );
    }

    function it_gets_user(
        LoggedInShopUserProviderInterface $loggedInShopUserProvider,
        ShopUserInterface $user,
        CustomerInterface $customer,
        UserProfileViewFactoryInterface $userProfileViewFactory,
        GenericSuccessViewFactoryInterface $genericSuccessViewFactory,
        ViewHandlerInterface $viewHandler
    ): void {
        $request = new Request();

        $loggedInShopUserProvider->provide()->willReturn($user);
        $user->getCustomer()->willReturn($customer);

        $userProfileViewFactory->create($customer)->willReturn(new UserProfileView());
        $genericSuccessViewFactory->create(Argument::any())->willReturn(new GenericSuccessView());
        $viewHandler->handle(Argument::any(), Argument::any())->willReturn(new Response());

        $this->__invoke($request);
    }
}
