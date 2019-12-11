<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Details;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct\ProductDetailsTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricing;
use Sylius\Component\Core\Model\ProductImage;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariant;

final class ProductDetailsTransformerSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductDetailsTransformer::class);
    }

    function let(ChannelContextInterface $channelContext): void
    {
        $this->beConstructedWith($channelContext);
    }

    function it_transforms(
        ChannelContextInterface $channelContext,
        ProductInterface $product,
        ChannelInterface $channel
    ): void {
        $product->getId()->willReturn(1);

        $productVariant = new ProductVariant();
        $channelPricing = new ChannelPricing();
        $channelPricing->setPrice(10);
        $productVariant->addChannelPricing($channelPricing);

        $product->getVariants()->willReturn(
            new ArrayCollection(
                [
                    $productVariant,
                ]
            )
        );
        $product->getCode()->willReturn('code');
        $product->getSlug()->willReturn('example-slug');
        $product->getName()->willReturn('example-name');

        $channelContext->getChannel()->willReturn($channel->getWrappedObject());

        $product->getCreatedAt()->willReturn(new \DateTime('yesterday'));
        $product->getUpdatedAt()->willReturn(new \DateTime('yesterday'));

        $product->getImages()->willReturn(
            new ArrayCollection(
                [
                    new ProductImage(),
                ]
            )
        );

        $product->getDescription()->willReturn('description');
        $product->getShortDescription()->willReturn('desc');

        $this->transform($product)->shouldReturnAnInstanceOf(Details::class);
    }
}
