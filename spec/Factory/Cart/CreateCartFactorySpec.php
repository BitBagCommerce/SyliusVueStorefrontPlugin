<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\CreateCart;
use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\CreateCartFactory;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

final class CreateCartFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(CreateCartFactory::class);
    }

    function it_is_creating_cart_from_DTO(): void
    {
        $request = new Request([
            'token' => 'token'
        ]);

        $createCartRequest = new CreateCartRequest($request);
        $this->createFromDTO($createCartRequest)->shouldReturnAnInstanceOf(CreateCart::class);
    }
}
