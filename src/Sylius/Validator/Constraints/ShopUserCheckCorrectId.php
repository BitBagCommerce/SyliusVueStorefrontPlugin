<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class ShopUserCheckCorrectId extends Constraint
{
    /** @var string */
    public $message = 'bitbag.vue_storefront_api.sylius.user.id.valid_id';

    public function validatedBy(): string
    {
        return 'sylius_shop_user_check_correct_id_validator';
    }
}
