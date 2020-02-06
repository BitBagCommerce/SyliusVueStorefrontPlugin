<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Command\Order\CreateOrder;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\AddressInformation;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\Product;
use BitBag\SyliusVueStorefrontPlugin\Request\RequestCommandInterface;

class CreateOrderRequest implements RequestCommandInterface
{
    /** @var string */
    public $user_id;

    /** @var int|string */
    public $cart_id;

    /** @var Product[] */
    public $products;

    /** @var AddressInformation */
    public $addressInformation;

    /** @var \DateTime */
    public $created_at;

    /** @var \DateTime */
    public $updated_at;

    public function getCommand(): CommandInterface
    {
        return new CreateOrder(
            $this->cart_id,
            $this->addressInformation,
            ...$this->products
        );
    }
}
