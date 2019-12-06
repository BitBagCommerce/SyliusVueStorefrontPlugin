<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Request\Stock;

use Symfony\Component\HttpFoundation\Request;

final class StockProductRequest
{
    /** @var string */
    private $sku;

    public function __construct(Request $request)
    {
        $this->sku = $request->get('sku');
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
