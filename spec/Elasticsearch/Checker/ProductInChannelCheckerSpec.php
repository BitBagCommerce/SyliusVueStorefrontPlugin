<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Checker;

use BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Checker\ProductInChannelChecker;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class ProductInChannelCheckerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductInChannelChecker::class);
    }

    function let(ChannelRepositoryInterface $channelRepository): void
    {
        $this->beConstructedWith($channelRepository, 'channel-code');
    }

    function it_checks_is_product_in_channel(
        ChannelRepositoryInterface $channelRepository,
        ProductInterface $syliusProduct,
        ChannelInterface $channel,
        ArrayCollection $collection
    ): void {
        $channelRepository->findOneByCode('channel-code')->willReturn($channel);

        $syliusProduct->getChannels()->willReturn($collection);

        $collection->contains($channel)->willReturn(true);

        $this->__invoke($syliusProduct);
    }
}
