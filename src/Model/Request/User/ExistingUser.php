<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\User;

class ExistingUser
{
    /** @var int */
    public $id;

    /** @var int */
    public $group_id;

    /** @var string|null */
    public $default_billing;

    /** @var string|null */
    public $default_shipping;

    /** @var \DateTime */
    public $created_at;

    /** @var \DateTime */
    public $updated_at;

    /** @var string */
    public $created_in;

    /** @var string */
    public $email;

    /** @var string */
    public $firstname;

    /** @var string */
    public $lastname;

    /** @var int */
    public $store_id;

    /** @var int */
    public $website_id;

    /** @var UserAddress[] */
    public $addresses;

    /** @var int */
    public $disable_auto_group_change;

    public function addresses(): array
    {
        return $this->addresses;
    }
}
