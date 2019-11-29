<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Address;

final class Region
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
