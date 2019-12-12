<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;

final class Region
{
    /** @var string|null */
    public $region_code;

    /** @var string|null */
    public $region;

    /** @var int|null */
    public $region_id;

    public function __construct(?string $region_code, ?string $region, ?int $region_id)
    {
        $this->region_code = $region_code;
        $this->region = $region;
        $this->region_id = $region_id;
    }
}
