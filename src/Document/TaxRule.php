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

use BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\Rates;

final class TaxRule implements Indexable
{
    private const ENTITY_ID = 'id';

    private const CODE = 'code';

    private const PRIORITY = 'priority';

    private const POSITION = 'position';

    private const CUSTOMER_TAX_CLASS_IDS = 'customer_tax_class_ids';

    private const PRODUCT_TAX_CLASS_IDS = 'product_tax_class_ids';

    private const TAX_RATE_IDS = 'tax_rate_ids';

    private const CALCULATE_SUBTOTAL = 'calculate_subtotal';

    private const TAX_RATES = 'rates';

    /** @var int */
    private $documentId;

    /** @var int */
    private $entityId;

    /** @var string */
    private $code;

    /** @var int */
    private $priority;

    /** @var int */
    private $position;

    /** @var int[] */
    private $customerTaxClassIds;

    /** @var int[] */
    private $productTaxClassIds;

    /** @var int[] */
    private $taxRateIds;

    /** @var bool */
    private $calculateSubtotal;

    /** @var Rates */
    private $taxRates;

    public function __construct(
        int $documentId,
        int $entityId,
        string $code,
        int $priority,
        int $position,
        array $customerTaxClassIds,
        array $productTaxClassIds,
        array $taxRateIds,
        bool $calculateSubtotal,
        Rates $taxRates
    ) {
        $this->documentId = $documentId;
        $this->entityId = $entityId;
        $this->code = $code;
        $this->priority = $priority;
        $this->position = $position;
        $this->customerTaxClassIds = $customerTaxClassIds;
        $this->productTaxClassIds = $productTaxClassIds;
        $this->taxRateIds = $taxRateIds;
        $this->calculateSubtotal = $calculateSubtotal;
        $this->taxRates = $taxRates;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function toElasticArray(): array
    {
        return [
            self::ENTITY_ID => $this->entityId,
            self::CODE => $this->code,
            self::PRIORITY => $this->priority,
            self::POSITION => $this->position,
            self::CUSTOMER_TAX_CLASS_IDS => $this->customerTaxClassIds,
            self::PRODUCT_TAX_CLASS_IDS => $this->productTaxClassIds,
            self::TAX_RATE_IDS => $this->taxRateIds,
            self::CALCULATE_SUBTOTAL => $this->calculateSubtotal,
            self::TAX_RATES => $this->taxRates,
        ];
    }
}
