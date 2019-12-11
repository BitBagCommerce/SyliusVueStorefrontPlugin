<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

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
