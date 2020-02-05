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

use BitBag\SyliusVueStorefrontPlugin\Document\Attribute\Option;

final class Attribute implements Indexable
{
    private const ENTITY_ID = 'id';

    private const ID = 'attribute_id';

    private const CODE = 'attribute_code';

    private const POSITION = 'position';

    private const OPTIONS = 'options';

    private const IS_UNIQUE = 'is_unique';

    private const IS_VISIBLE = 'is_visible';

    private const IS_COMPARABLE = 'is_comparable';

    private const IS_USER_DEFINED = 'is_user_defined';

    private const IS_VISIBLE_ON_FRONTEND = 'is_visible_on_front';

    private const FRONTEND_INPUT = 'frontend_input';

    private const FRONTEND_LABEL = 'frontend_label';

    //    TODO SAMPLE FROM VS API CATALOG_BACKUP.JSON ONLY

    private const IS_WYSIWYG_ENABLED = 'is_wysiwyg_enabled';

    private const IS_HTML_ALLOWED_ON_FRONTEND = 'is_html_allowed_on_frontend';

    private const IS_USED_FOR_SORTING = 'used_for_sort_by';

    private const IS_FILTERABLE = 'is_filterable';

    private const IS_FILTERABLE_IN_SEARCH = 'is_filterable_in_search';

    private const IS_USED_IN_GRID = 'is_used_in_grid';

    private const IS_VISIBLE_IN_GRID = 'is_visible_in_grid';

    private const IS_FILTERABLE_IN_GRID = 'is_filterable_in_grid';

    private const APPLY_TO = 'apply_to';

    private const IS_SEARCHABLE = 'is_searchable';

    private const IS_VISIBLE_IN_ADVANCED_SEARCH = 'is_visible_in_advanced_search';

    private const IS_USED_FOR_PROMO_RULES = 'is_used_for_promo_rules';

    private const IS_USED_IN_PRODUCT_LISTING = 'used_in_product_listing';

    private const SCOPE = 'scope';

    private const ENTITY_TYPE_ID = 'entity_type_id';

    private const IS_REQUIRED = 'is_required';

    private const DEFAULT_FRONTEND_LABEL = 'default_frontend_label';

    private const FRONTEND_LABELS = 'frontend_labels';

    private const BACKEND_TYPE = 'backend_type';

    private const SOURCE_MODEL = 'source_model';

    private const DEFAULT_VALUE = 'default_value';

    private const VALIDATION_RULES = 'validation_rules';

    /** @var int */
    private $documentId;

    /** @var int */
    private $entityId;

    /** @var int */
    private $id;

    /** @var string */
    private $code;

    /** @var int */
    private $position;

    /** @var Option[] */
    private $options;

    /** @var bool */
    private $isUnique;

    /** @var bool */
    private $isVisible;

    /** @var bool */
    private $isComparable;

    /** @var bool */
    private $isUserDefined;

    /** @var bool */
    private $isVisibleOnFrontend;

    /** @var string */
    private $frontendInput;

    /** @var string */
    private $frontendLabel;

    //    TODO SAMPLE FROM VS API CATALOG_BACKUP.JSON ONLY, BELOW FRONTEND_LABELS, ABOVE FRONTEND_LABEL

    /** @var bool */
    private $isWysiwygEnabled = false;

    /** @var bool */
    private $isHtmlAllowedOnFronted = false;

    /** @var bool */
    private $isUsedForSorting = false;

    /** @var bool */
    private $isFilterable = false;

    /** @var bool */
    private $isFilterableInSearch = false;

    /** @var bool */
    private $isUsedInGrid = false;

    /** @var bool */
    private $isVisibleInGrid = false;

    /** @var bool */
    private $isFilterableInGrid = false;

    /** @var array */
    private $applyTo = [];

    /** @var bool */
    private $isSearchable = false;

    /** @var bool */
    private $isVisibleInAdvancedSearch = false;

    /** @var bool */
    private $isUsedForPromoRules = false;

    /** @var bool */
    private $isUsedInProductListing = false;

    /** @var string */
    private $scope = 'store';

    /** @var int */
    private $entityTypeId = 4;

    /** @var bool */
    private $isRequired = false;

    /** @var string */
    private $defaultFrontendLabel;

    /** @var array|null */
    private $frontendLabels;

    /** @var string */
    private $backendType = 'varchar';

    /** @var string */
    private $sourceModel = 'Magento\Catalog\Model\Entity\Product\Attribute\Design\Options\Container';

    /** @var string */
    private $defaultValue = 'container2';

    /** @var array */
    private $validationRules = [];

    public function __construct(
        int $documentId,
        int $entityId,
        int $id,
        string $code,
        int $position,
        array $options,
        bool $isUnique,
        bool $isVisible,
        bool $isComparable,
        bool $isUserDefined,
        bool $isVisibleOnFrontend,
        string $frontendInput,
        string $frontendLabel
    ) {
        $this->documentId = $documentId;
        $this->entityId = $entityId;
        $this->id = $id;
        $this->code = $code;
        $this->position = $position;
        $this->options = $options;
        $this->isUnique = $isUnique;
        $this->isVisible = $isVisible;
        $this->isComparable = $isComparable;
        $this->isUserDefined = $isUserDefined;
        $this->isVisibleOnFrontend = $isVisibleOnFrontend;
        $this->frontendInput = $frontendInput;
        $this->frontendLabel = $frontendLabel;
        $this->defaultFrontendLabel = $frontendLabel;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function toElasticArray(): array
    {
        return [
            self::ENTITY_ID => $this->entityId,
            self::ID => $this->id,
            self::CODE => $this->code,
            self::POSITION => $this->position,
            self::OPTIONS => $this->options,
            self::IS_UNIQUE => $this->isUnique,
            self::IS_VISIBLE => $this->isVisible,
            self::IS_COMPARABLE => $this->isComparable,
            self::IS_USER_DEFINED => $this->isUserDefined,
            self::IS_VISIBLE_ON_FRONTEND => $this->isVisibleOnFrontend,
            self::FRONTEND_INPUT => $this->frontendInput,
            self::FRONTEND_LABEL => $this->frontendLabel,
            self::IS_WYSIWYG_ENABLED => $this->isWysiwygEnabled,
            self::IS_HTML_ALLOWED_ON_FRONTEND => $this->isHtmlAllowedOnFronted,
            self::IS_USED_FOR_SORTING => $this->isUsedForSorting,
            self::IS_FILTERABLE => $this->isFilterable,
            self::IS_FILTERABLE_IN_SEARCH => $this->isFilterableInSearch,
            self::IS_USED_IN_GRID => $this->isUsedInGrid,
            self::IS_VISIBLE_IN_GRID => $this->isVisibleInGrid,
            self::IS_FILTERABLE_IN_GRID => $this->isFilterableInGrid,
            self::APPLY_TO => $this->applyTo,
            self::IS_SEARCHABLE => $this->isSearchable,
            self::IS_VISIBLE_IN_ADVANCED_SEARCH => $this->isVisibleInAdvancedSearch,
            self::IS_USED_FOR_PROMO_RULES => $this->isUsedForPromoRules,
            self::IS_USED_IN_PRODUCT_LISTING => $this->isUsedInProductListing,
            self::SCOPE => $this->scope,
            self::ENTITY_TYPE_ID => $this->entityTypeId,
            self::IS_REQUIRED => $this->isRequired,
            self::DEFAULT_FRONTEND_LABEL => $this->defaultFrontendLabel,
            self::FRONTEND_LABELS => $this->frontendLabels,
            self::BACKEND_TYPE => $this->backendType,
            self::SOURCE_MODEL => $this->sourceModel,
            self::DEFAULT_VALUE => $this->defaultValue,
            self::VALIDATION_RULES => $this->validationRules,
        ];
    }
}
