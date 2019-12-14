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

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Price;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantPricesTransformer implements ProductVariantPricesTransformerInterface
{
    /** @var ChannelProviderInterface */
    private $channelProvider;

    public function __construct(ChannelProviderInterface $channelProvider)
    {
        $this->channelProvider = $channelProvider;
    }

    public function transform(ProductVariantInterface $productVariant): Price
    {
        $channelPricing = $productVariant->getChannelPricingForChannel($this->channelProvider->provide());
        $price = (float) $channelPricing->getPrice();
        $originalPrice = (float) $channelPricing->getOriginalPrice();

        return new Price(
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $price,
            $originalPrice,
            $originalPrice,
            $originalPrice
        );
    }
}
