<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product\ConfigurableChildren;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Price;

final class Child implements \JsonSerializable
{
    private const PRICE = 'price';
    private const NAME = 'name';
    private const SKU = 'sku';
    private const CUSTOM_ATTRIBUTES = 'custom_attributes';

    //    TODO FIELDS INSIDE CHILD IN DEMO APP ONLY below, IN DOCS '$price' is not whole Price class
    //     + categoryIds[] + options[] + product_options[] -custom_attributes[]

    //    private const DEMO_APP = [
    //        Details::IMAGE, Details::THUMBNAIL, Details::COLOR, Details::SMALL_IMAGE, Details::TAX_CLASS_ID,
    //        Details::HAS_OPTIONS, Details::URL_KEY, Details::SIZE, Details::NAME, Details::STATUS,
    //    ];

    /** @var Price */
    private $price;

    /** @var string */
    private $name;

    /** @var string */
    private $sku;

    /** @var array */
    private $customAttributes;

    public function __construct(
        Price $price,
        string $name,
        string $sku,
        array $customAttributes
    ) {
        $this->price = $price;
        $this->name = $name;
        $this->sku = $sku;
        $this->customAttributes = $customAttributes;
    }

    public function jsonSerialize(): array
    {
        return \array_merge(
            $this->price->toArray(),
            [
                self::NAME => $this->name,
                self::SKU => $this->sku,
            ],
            $this->customAttributes
        );
    }
}
