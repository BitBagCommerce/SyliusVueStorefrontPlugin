<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\DependencyInjection;

use BitBag\SyliusVueStorefrontPlugin\DependencyInjection\SyliusVueStorefrontExtension;
use PhpSpec\ObjectBehavior;

final class SyliusVueStorefrontExtensionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SyliusVueStorefrontExtension::class);
    }
}
