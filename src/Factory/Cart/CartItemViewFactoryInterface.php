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

use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderItemInterface as SyliusOrderItemInterface;

interface CartItemViewFactoryInterface
{
    public function create(SyliusOrderItemInterface $syliusOrderItem): CartItemView;

    /** @return array|CartItemView[] */
    public function createList(Collection $syliusOrderItems): array;
}
