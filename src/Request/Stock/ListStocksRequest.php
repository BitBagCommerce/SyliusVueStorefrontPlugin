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

final class ListStocksRequest
{
    /** @var string */
    private $skus;

    public function __construct(Request $request)
    {
        $this->skus = $request->query->get('skus');
    }

    public static function fromHttpRequest(Request $request): self
    {
        return new self($request);
    }

    public function SKUsToArray(): array
    {
        return explode(',', $this->skus);
    }
}
