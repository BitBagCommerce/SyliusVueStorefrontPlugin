<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Elasticsearch\Property\NameResolver;

final class PrefixedNameResolver implements PrefixedNameResolverInterface
{
    /**
     * @var string
     */
    private $propertyPrefix;

    public function __construct(string $propertyPrefix)
    {
        $this->propertyPrefix = $propertyPrefix;
    }

    public function resolvePropertyName(string $suffix): string
    {
        return strtolower(sprintf('%s_%s', $this->propertyPrefix, $suffix));
    }
}
