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

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;

final class ExistingUser
{
    public const ID = 'id';
    public const GROUP_ID = 'group_id';
    public const DEFAULT_BILLING = 'default_billing';
    public const DEFAULT_SHIPPING = 'default_shipping';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const CREATED_IN = 'created_in';
    public const EMAIL = 'email';
    public const FIRST_NAME = 'firstname';
    public const LAST_NAME = 'lastname';
    public const STORE_ID = 'store_id';
    public const WEBSITE_ID = 'website_id';
    public const ADDRESSES = 'addresses';
    public const DISABLE_AUTOMATIC_GROUP_CHANGE = 'disable_auto_group_change';

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

    /** @var Address[] */
    public $addresses;

    /** @var int */
    public $disable_auto_group_change;

    public function __construct(int $id, int $group_id, ?string $default_billing, ?string $default_shipping, \DateTime $created_at, \DateTime $updated_at, string $created_in, string $email, string $firstname, string $lastname, int $store_id, int $website_id, array $addresses, int $disable_auto_group_change)
    {
        $this->id = $id;
        $this->group_id = $group_id;
        $this->default_billing = $default_billing;
        $this->default_shipping = $default_shipping;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->created_in = $created_in;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->store_id = $store_id;
        $this->website_id = $website_id;
        $this->addresses = $addresses;
        $this->disable_auto_group_change = $disable_auto_group_change;
    }

    public function addresses(): array
    {
        return $this->addresses;
    }
}
