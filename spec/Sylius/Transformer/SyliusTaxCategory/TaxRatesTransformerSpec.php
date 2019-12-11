<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory;

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusTaxCategory\TaxRatesTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Addressing\Model\Zone;
use Sylius\Component\Core\Model\TaxRateInterface;

final class TaxRatesTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(TaxRatesTransformer::class);
    }

    function it_transforms(TaxRateInterface $taxRate): void
    {
        $zone = new Zone();
        $zone->setName('name');
        $zone->setType('country');

        $taxRate->getId()->willReturn(1);
        $taxRate->getCode()->willReturn('code');
        $taxRate->getAmountAsPercentage()->willReturn(10.0);
        $taxRate->getZone()->willReturn($zone);

        $this->transform(
            new ArrayCollection(
                [
                    $taxRate->getWrappedObject(),
                ]
            )
        )->shouldReturnAnInstanceOf(Rates::class);
    }
}
