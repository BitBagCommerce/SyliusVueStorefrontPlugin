<?php

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
