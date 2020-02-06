<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Document\TaxRule\TaxRate;

class Rate implements \JsonSerializable
{
    private const ID = 'id';

    private const CODE = 'code';

    private const RATE = 'rate';

    private const COUNTRY_NAME = 'tax_country_id';

    private const REGION_ID = 'tax_region_id';

    private const POSTCODE = 'tax_postcode';

    private const IS_ZIP_RANGE = 'zip_is_range';

    private const ZIP_RANGE_START = 'zip_from';

    private const ZIP_RANGE_END = 'zip_to';

    /** @var int */
    private $id;

    /** @var string */
    private $code;

    /** @var int */
    private $rate;

    /** @var string */
    private $countryName;

    /** @var int */
    private $regionId;

    /** @var int */
    private $postcode;

    /** @var bool|null */
    private $isZipRange;

    /** @var string|null */
    private $zipRangeStart;

    /** @var string|null */
    private $zipRangeEnd;

    public function __construct(
        int $id,
        string $code,
        int $rate,
        string $countryName,
        int $regionId,
        int $postcode,
        ?bool $isZipRange,
        ?string $zipRangeStart,
        ?string $zipRangeEnd
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->rate = $rate;
        $this->countryName = $countryName;
        $this->regionId = $regionId;
        $this->postcode = $postcode;
        $this->isZipRange = $isZipRange;
        $this->zipRangeStart = $zipRangeStart;
        $this->zipRangeEnd = $zipRangeEnd;
    }

    public function jsonSerialize(): array
    {
        return [
            self::ID => $this->id,
            self::CODE => $this->code,
            self::RATE => $this->rate,
            self::COUNTRY_NAME => $this->countryName,
            self::REGION_ID => $this->regionId,
            self::POSTCODE => $this->postcode,
            self::IS_ZIP_RANGE => $this->isZipRange,
            self::ZIP_RANGE_START => $this->zipRangeStart,
            self::ZIP_RANGE_END => $this->zipRangeEnd,
        ];
    }
}
