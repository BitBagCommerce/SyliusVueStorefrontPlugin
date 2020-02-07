<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory\Common\Address;

use BitBag\SyliusVueStorefrontPlugin\Factory\Common\Address\RegionViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\Common\Address\RegionView;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Addressing\Model\AddressInterface as SyliusAddressInterface;

final class RegionViewFactorySpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(RegionView::class);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RegionViewFactory::class);
    }

    function it_creates_region_view(SyliusAddressInterface $address): void
    {
        $this->create($address)->shouldReturnAnInstanceOf(RegionView::class);
    }
}
