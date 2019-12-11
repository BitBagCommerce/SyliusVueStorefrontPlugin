<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\PaymentMethodViewFactory;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\PaymentMethodInterface;

final class PaymentMethodViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PaymentMethodViewFactory::class);
    }

    function it_creates_payment_method_views(
        PaymentMethodInterface $paymentMethod
    ): void {
       $this->createList(
           [
               $paymentMethod,
               $paymentMethod,
           ]
       )->shouldBeArray();
    }
}
