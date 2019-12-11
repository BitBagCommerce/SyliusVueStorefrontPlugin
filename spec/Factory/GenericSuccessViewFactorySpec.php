<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\Factory\GenericSuccessViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use PhpSpec\ObjectBehavior;

final class GenericSuccessViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GenericSuccessViewFactory::class);
    }

    function it_creates_generic_success_view(): void
    {
        $this->create('example-value')->shouldReturnAnInstanceOf(GenericSuccessView::class);
    }
}
