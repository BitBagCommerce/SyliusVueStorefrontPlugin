<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Bridge\Mapper;

interface ProductMapperInterface
{
    public const DEFAULT_ATTRIBUTE_SET_ID = 11;
    public const DEFAULT_STATUS = 1;
    public const DEFAULT_VISIBILITY = 4;
    public const SIMPLE_TYPE = 'simple';
    public const TYPE_CONFIGURABLE = 'configurable';
    public const DEFAULT_CATEGORY_ID = 2;
    public const DEFAULT_AVAILABILITY = '1';
    public const DEFAULT_OPTION_STATUS = 'Enabled';
    public const DEFAULT_TAX_CLASS_ID = 2;
    public const DEFAULT_OPTION_CLASS_ID = 'Taxable Goods';
    public const DEFAULT_CATEGORY = 'Default category';
}
