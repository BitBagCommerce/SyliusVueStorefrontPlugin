<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\Product\Category;

final class Entity implements \JsonSerializable
{
    private const CATEGORY_ID = 'category_id';
    private const IS_PARENT = 'is_parent';
    private const NAME = 'name';
    private const SLUG = 'slug';
    private const PATH = 'path';

//    TODO CATEGORY IN VS DOCS / DEMO APP
    private const VS_DOCS = [self::CATEGORY_ID, self::NAME];
    private const DEMO_APP = [self::PATH, self::CATEGORY_ID, self::NAME, self::SLUG];

    /** @var int */
    private $id;

    /** @var bool */
    private $isParent;

    /** @var string */
    private $name;

    /** @var string */
    private $slug;

    /** @var string */
    private $path;

    public function __construct(int $id, bool $isParent, string $name, string $slug, string $path)
    {
        $this->id = $id;
        $this->isParent = $isParent;
        $this->name = $name;
        $this->slug = $slug;
        $this->path = $path;
    }

    public function jsonSerialize(): array
    {
        return [
            self::CATEGORY_ID => $this->id,
            self::IS_PARENT => $this->isParent,
            self::NAME => $this->name,
            self::SLUG => $this->slug,
            self::PATH => $this->path,
        ];
    }
}
