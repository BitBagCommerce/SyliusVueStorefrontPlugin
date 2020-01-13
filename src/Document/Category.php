<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document;

final class Category implements Indexable
{
    private const ENTITY_ID = 'id';
    private const PARENT_ID = 'parent_id';
    private const NAME = 'name';
    private const IS_ACTIVE = 'is_active';
    private const POSITION = 'position';
    private const LEVEL = 'level';
    private const PRODUCT_COUNT = 'product_count';
    private const CHILDREN_DATA = 'children_data';
    private const PATH = 'path';
    private const CHILDREN_COUNT = 'children_count';
    private const URL_KEY = 'url_key';
    private const URL_PATH = 'url_path';
    private const SLUG = 'slug';

    /** @var int */
    private $documentId;

    /** @var int */
    private $entityId;

    /** @var int|null */
    private $parentId;

    /** @var string */
    private $name;

    /** @var bool */
    private $isActive;

    /** @var int */
    private $position;

    /** @var int */
    private $level;

    /** @var int */
    private $productCount;

    /** @var self[] */
    private $childrenData;

    /** @var string */
    private $path;

    /** @var int */
    private $childrenCount;

    /** @var string */
    private $urlKey;

    /** @var string */
    private $urlPath;

    public function __construct(
        int $documentId,
        int $entityId,
        ?int $parentId,
        string $name,
        bool $isActive,
        int $position,
        int $level,
        int $productCount,
        array $childrenData,
        string $path,
        int $childrenCount,
        string $urlKey,
        string $urlPath
    ) {
        $this->documentId = $documentId;
        $this->entityId = $entityId;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->position = $position;
        $this->level = $level;
        $this->productCount = $productCount;
        $this->childrenData = $childrenData;
        $this->path = $path;
        $this->childrenCount = $childrenCount;
        $this->urlKey = $urlKey;
        $this->urlPath = $urlPath;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function toElasticArray(): array
    {
        return [
            self::ENTITY_ID => $this->entityId,
            self::PARENT_ID => $this->parentId,
            self::NAME => $this->name,
            self::IS_ACTIVE => $this->isActive,
            self::POSITION => $this->position,
            self::LEVEL => $this->level,
            self::PRODUCT_COUNT => $this->productCount,
            self::CHILDREN_DATA => $this->childrenData,
            self::PATH => $this->path,
            self::CHILDREN_COUNT => (string) $this->childrenCount,
            self::URL_KEY => $this->urlKey,
            self::URL_PATH => $this->urlPath,
            self::SLUG => $this->urlKey,
        ];
    }
}
