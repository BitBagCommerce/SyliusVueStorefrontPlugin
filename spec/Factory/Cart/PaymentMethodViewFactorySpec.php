<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Factory\Cart\PaymentMethodViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\PaymentMethodView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\PaymentMethodInterface;

final class PaymentMethodViewFactorySpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(PaymentMethodView::class);
    }

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
