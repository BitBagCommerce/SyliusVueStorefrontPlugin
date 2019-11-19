<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model;

final class OrderProduct
{
    private const SKU = 'sku';
    private const QUANTITY = 'quantity';

    /** @var string */
    private $sku;

    /** @var int */
    private $quantity;

    public function __construct(string $sku, int $quantity)
    {
        $this->sku = $sku;
        $this->quantity = $quantity;
    }

    //    public static function createFromArray(array $addressInformation): self
    //    {
    //
    //    }
}
