<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product;

use BitBag\SyliusVueStorefrontPlugin\Document\Product\Category\Entity;

final class Category
{
    private const CATEGORY = 'category';
    private const CATEGORY_IDS = 'category_ids';

    /** @var int[] */
    private $ids;

    /** @var Entity[] */
    private $entities;

    public function __construct(array $entities, array $ids)
    {
        $this->entities = $entities;
        $this->ids = $ids;
    }

    public function toArray(): array
    {
        return [
          self::CATEGORY => $this->entities,
          self::CATEGORY_IDS => $this->ids,
        ];
    }
}
