<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Address;

class Region
{
    /** @var string|null */
    private $regionCode;

    /** @var string|null */
    private $region;

    /** @var int|null */
    private $regionId;

    public function __construct(
        ?string $regionCode,
        ?string $region,
        ?int $regionId
    ) {
        $this->regionCode = $regionCode;
        $this->region = $region;
        $this->regionId = $regionId;
    }
}
