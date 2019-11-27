<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class CartTokenValueIsNotUsed extends Constraint
{
    /** @var string */
    public $message = 'bitbag.vue_storefront_api.sylius.cart.token_value.unique';

    public function validatedBy(): string
    {
        return 'sylius_cart_token_value_is_not_used_validator';
    }
}
