<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use BitBag\SyliusVueStorefrontPlugin\Controller\Cart\SetShippingInformationAction;
use PhpSpec\ObjectBehavior;

/**
 * @todo
 */
final class SetShippingInformationActionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SetShippingInformationAction::class);
    }
}
