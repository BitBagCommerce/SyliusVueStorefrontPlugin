<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\AddressInformation;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Order\Product;

class CreateOrder implements CommandInterface
{
    /** @var string|null */
    protected $cartId;

    /** @var AddressInformation */
    protected $addressInformation;

    /** @var Product[] */
    protected $products;

    public function __construct(
        ?string $cartId,
        AddressInformation $addressInformation,
        Product ...$products
    ) {
        $this->cartId = $cartId;
        $this->addressInformation = $addressInformation;
        $this->products = $products;
    }

    public function cartId(): ?string
    {
        return $this->cartId;
    }

    public function addressInformation(): AddressInformation
    {
        return $this->addressInformation;
    }

    public function products(): array
    {
        return $this->products;
    }
}
