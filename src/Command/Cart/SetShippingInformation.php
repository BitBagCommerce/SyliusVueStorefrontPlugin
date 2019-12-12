<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Command\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\CommandInterface;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\Cart\AddressInformation;

final class SetShippingInformation implements CommandInterface
{
    /** @var string|null */
    private $token;

    /** @var string */
    private $cartId;

    /** @var AddressInformation */
    private $addressInformation;

    public function __construct(?string $token, string $cartId, AddressInformation $addressInformation)
    {
        $this->token = $token;
        $this->cartId = $cartId;
        $this->addressInformation = $addressInformation;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function addressInformation(): AddressInformation
    {
        return $this->addressInformation;
    }
}
