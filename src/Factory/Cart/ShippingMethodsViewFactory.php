<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Cart;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\ShippingMethodsView;
use Sylius\Component\Core\Model\ShippingMethodInterface;

final class ShippingMethodsViewFactory implements ShippingMethodsViewFactoryInterface
{
    /** @var ChannelProviderInterface */
    private $channelProvider;

    public function __construct(ChannelProviderInterface $channelProvider)
    {
        $this->channelProvider = $channelProvider;
    }

    public function createList(ShippingMethodInterface ...$shippingMethods): array
    {
        $shippingMethodList = [];

        foreach ($shippingMethods as $shippingMethod) {
            $shippingMethodList[] = $this->createFromShippingMethod($shippingMethod);
        }

        return $shippingMethodList;
    }

    private function createFromShippingMethod(ShippingMethodInterface $shippingMethod): ShippingMethodsView
    {
        $shippingMethodsView = new ShippingMethodsView();
        $shippingMethodsView->carrier_code = $shippingMethod->getCode();
        $shippingMethodsView->method_code = $shippingMethod->getCode();
        $shippingMethodsView->carrier_title = $shippingMethod->getTranslation()->getName();
        $shippingMethodsView->method_title = $shippingMethod->getTranslation()->getName();

        $configuration = $shippingMethod->getConfiguration();
        $channelCode = $this->channelProvider->provide()->getCode();

        $shippingMethodsView->amount = (int) $configuration[$channelCode]['amount'];
        $shippingMethodsView->base_amount = (int) $configuration[$channelCode]['amount'];

        $shippingMethodsView->available = $shippingMethod->isEnabled();
        $shippingMethodsView->error_message = '';
        $shippingMethodsView->price_excl_tax = 0;
        $shippingMethodsView->price_incl_tax = 0;

        return $shippingMethodsView;
    }
}
