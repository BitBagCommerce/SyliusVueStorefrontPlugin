<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProduct;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Details;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ProductInterface;

final class ProductDetailsTransformer implements ProductDetailsTransformerInterface
{
    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(ChannelContextInterface $channelContext)
    {
        $this->channelContext = $channelContext;
    }

    public function transform(ProductInterface $product): Details
    {
        return new Details(
            $product->getId(),
            null,
            null,
            count($product->getVariants()) > 1 ? 'configurable' : 'simple',
            $product->getCode(),
            $product->getSlug(),
            $product->getName(),
            $product->getVariants()->first()->getChannelPricingForChannel($this->channelContext->getChannel())->getPrice(),
            null,
            null,
            $product->getCreatedAt(),
            $product->getUpdatedAt(),
            5, //weight
            $product->getCode(),
            $product->getImages()->first()->getPath(),
            $product->getVariants()->first()->getOnHand() > 0,
            null,
            $product->getVariants()->first()->getTaxCategory() !== null ? $product->getVariants()->first()->getTaxCategory()->getId() : null,
            $product->getVariants()->first()->getTaxCategory() !== null ? $product->getVariants()->first()->getTaxCategory()->getName() : null,
            $product->getDescription(),
            $product->getShortDescription(),
            1,//hasOptions
            1,//requiredOptions
            [],//productLinks
            [],//colorOptions,
            [],//sizeOptions
            false
        //            [],//configurableOptions
        //            []//configurableChildren
        );
    }
}
