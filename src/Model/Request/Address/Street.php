<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\Address;

class Street
{
    /** @var array */
    private $streets = [];

    public function __construct(array $streets)
    {
        $this->streets = $streets;
    }
}
