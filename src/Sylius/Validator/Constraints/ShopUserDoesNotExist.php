<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class ShopUserDoesNotExist extends Constraint
{
    /** @var string */
    public $message = 'bitbag_vue_storefront_api.sylius.email.unique';

    /** {@inheritdoc} */
    public function validatedBy(): string
    {
        return 'sylius_shop_user_does_not_exist_validator';
    }
}
