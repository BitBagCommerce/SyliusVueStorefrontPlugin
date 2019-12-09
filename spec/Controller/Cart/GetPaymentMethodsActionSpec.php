<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\GetPaymentMethodsAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class GetPaymentMethodsActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetPaymentMethodsAction::class);
    }
}
