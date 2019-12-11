<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Factory;

use BitBag\SyliusVueStorefrontPlugin\Factory\RegionViewFactory;
use BitBag\SyliusVueStorefrontPlugin\View\RegionView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Addressing\Model\AddressInterface as SyliusAddressInterface;

final class RegionViewFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(RegionViewFactory::class);
    }

    function it_creates_region_view(SyliusAddressInterface $address): void
    {
        $this->create($address)->shouldReturnAnInstanceOf(RegionView::class);
    }
}
