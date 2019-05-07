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
use Sylius\Component\Core\Model\ProductVariantInterface as SyliusProductVariantInterface;

final class Product implements ProductInterface
{
    /** @var int */
    private $entityId;

//    /** @var string */
//    private $typeId;

    /** @var string */
    private $sku;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var string */
    private $name;

    //    /** @var Price[] */
    //    private $price;
    //
    //    /** @var int[] */
    //    private $status;

    /** @var string */
    private $description;

//    /** @var string */
//    private $shortDescription;

    public function __construct(
        int $entityId,
        string $sku,
        string $createdAt,
        string $updatedAt,
        string $name,
        string $description
//        string $shortDescription
    ) {
        $this->entityId = $entityId;
        $this->sku = $sku;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->name = $name;
        $this->description = $description;
//        $this->shortDescription = $shortDescription;
        //        $this->type = $type;
        //        $this->names = $names;
    }

    public static function fromSyliusProductVariant(SyliusProductVariantInterface $productVariant): self
    {
        return new self(
            $productVariant->getId(),
            $productVariant->getCode(),
            $productVariant->getCreatedAt()->format(self::DATE_FORMAT),
            $productVariant->getUpdatedAt()->format(self::DATE_FORMAT),
            $productVariant->getTranslation('en_US')->getName(),
            $productVariant->getProduct()->getTranslation('en_US')->getDescription()
//            $productVariant->getProduct()->
        );
    }

    public function toArray(): array
    {
        return \get_object_vars($this);
    }
}
