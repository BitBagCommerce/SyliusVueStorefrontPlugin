<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Factory;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;

interface CartFactoryInterface
{
    public function createForCustomerAndChannel(
        CustomerInterface $customer,
        ChannelInterface $channel
    ): OrderInterface;

    public function createForChannel(ChannelInterface $channel): OrderInterface;
}
