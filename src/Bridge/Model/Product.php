<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Model;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product\Price;
use Sylius\Component\Core\Model\ProductInterface;

final class Product
{
    /** @var int */
    private $id;

    /** @var string */
    private $sku;

    /** @var string */
    private $typeId;

    /** @var string[] */
    private $name;

    /** @var Price[] */
    private $price;

    private $status;

    public function __construct(int $entityId, string $sku, string $type, array $names)
    {
        $this->entityId = $entityId;
        $this->sku = $sku;
        $this->type = $type;
        $this->names = $names;
    }

    public static function fromSyliusProduct(ProductInterface $product): self
    {
        return new self($product->getId(), $product->getCode());
    }
}
