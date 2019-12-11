<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\GetAppliedCouponAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class GetAppliedCouponActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GetAppliedCouponAction::class);
    }
}
