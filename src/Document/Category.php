<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document;

use Webmozart\Assert\Assert;

final class Category implements \JsonSerializable
{
    private const ENTITY_ID = 'id';
    private const PARENT_ID = 'parent_id';
    private const NAME = 'name';
    private const IS_ACTIVE = 'is_active';
    private const POSITION = 'position';
    private const LEVEL = 'level';
    private const PRODUCT_COUNT = 'product_count';
    private const CHILDREN_DATA = 'children_data';
    private const CHILDREN = 'children';
    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';
    private const PATH = 'path';
    private const SORT_BY = 'available_sort_by';
    private const INCLUDE_IN_MENU = 'include_in_menu';
    private const DISPLAY_MODE = 'display_mode';
    private const IS_ANCHOR = 'is_anchor';
    private const PAGE_LAYOUT = 'page_layout';
    private const CHILDREN_COUNT = 'children_count';
    private const URL_KEY = 'url_key';
    private const URL_PATH = 'url_path';

    private const REQUEST_PATH = 'request_path';
    //    private const TSK = 'tsk';

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private const SORT_BY_VALUES = ['position', 'name', 'price'];
    private const DISPLAY_MODES = ['PRODUCTS_AND_PAGE', 'PAGE', 'PRODUCTS'];
    private const PAGE_LAYOUTS = ['empty', '1column', '2columns-left', '2columns-right', '3columns'];
    private const DEFAULT_DISPLAY_MODE = 'PAGE';
    private const DEFAULT_PAGE_LAYOUT = '1column';

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
    private $children;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var string */
    private $path;

    /** @var string[]|null */
    private $sortBy;

    /** @var bool */
    private $includeInMenu;

    /** @var string */
    private $displayMode;

    /** @var bool, enable display of products from children categories in this category */
    private $isAnchor;

    /** @var string */
    private $pageLayout;

    /** @var int */
    private $childrenCount;

    /** @var string */
    private $urlKey;

    /** @var string */
    private $urlPath;

    /** @var string */
    //    private $requestPath = 'women/tops.html';
    private $requestPath;

    //    /** @var int */
    //    private $tsk = 1556379380757;

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
        string $children,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        string $path,
        ?array $sortBy,
        bool $includeInMenu,
        ?string $displayMode,
        bool $isAnchor,
        ?string $pageLayout,
        int $childrenCount,
        string $urlKey,
        string $urlPath,
        string $requestPath
    ) {
        Assert::nullOrOneOf($displayMode, self::DISPLAY_MODES);
        Assert::nullOrOneOf($pageLayout, self::PAGE_LAYOUTS);
        Assert::allOneOf($sortBy, self::SORT_BY_VALUES);

        $this->documentId = $documentId;
        $this->entityId = $entityId;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->isActive = $isActive;
        $this->position = $position;
        $this->level = $level;
        $this->productCount = $productCount;
        $this->childrenData = $childrenData;
        $this->children = $children;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->path = $path;
        $this->sortBy = $sortBy;
        $this->includeInMenu = $includeInMenu;
        $this->displayMode = $displayMode ?? self::DEFAULT_DISPLAY_MODE;
        $this->isAnchor = $isAnchor;
        $this->pageLayout = $pageLayout ?? self::DEFAULT_PAGE_LAYOUT;
        $this->childrenCount = $childrenCount;
        $this->urlKey = $urlKey;
        $this->urlPath = $urlPath;
        $this->requestPath = $requestPath;
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
            self::CHILDREN => $this->children,
            self::CREATED_AT => $this->createdAt->format(self::DATE_FORMAT),
            self::UPDATED_AT => $this->updatedAt->format(self::DATE_FORMAT),
            self::PATH => $this->path,
            self::SORT_BY => $this->sortBy,
            self::INCLUDE_IN_MENU => (int) $this->includeInMenu,
            self::DISPLAY_MODE => $this->displayMode,
            self::IS_ANCHOR => (string) $this->isAnchor,
            self::PAGE_LAYOUT => $this->pageLayout,
            self::CHILDREN_COUNT => (string) $this->childrenCount,
            self::URL_KEY => $this->urlKey,
            self::URL_PATH => $this->urlPath,
            self::REQUEST_PATH => $this->requestPath,
            //            self::TSK => $this->tsk,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toElasticArray();
    }
}
