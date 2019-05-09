<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Model\Product;

use Sylius\Component\Core\Model\TaxonInterface;

final class Category implements \JsonSerializable
{
    private const CATEGORY_ID = 'category_id';
    private const IS_PARENT = 'is_parent';
    private const NAME = 'name';

    /** @var int */
    private $id;

    /** @var bool */
    private $isParent;

    /** @var string */
    private $name;

    private function __construct(int $id, bool $isParent, string $name)
    {
        $this->id = $id;
        $this->isParent = $isParent;
        $this->name = $name;
    }

    public static function fromSyliusTaxon(TaxonInterface $taxon): self
    {
        return new self(
            $taxon->getId(),
            $taxon->hasChildren(),
            $taxon->getName()
        );
    }

    public function jsonSerialize()
    {
        return [
            self::CATEGORY_ID => $this->id,
            self::IS_PARENT => $this->isParent,
            self::NAME => $this->name
        ];
    }
}
