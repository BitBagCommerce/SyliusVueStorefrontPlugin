<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\View\User;

use BitBag\SyliusVueStorefrontPlugin\View\AddressView;

final class UserProfileView
{
    /** @var int */
    public $id;

    /** @var int */
    public $group_id;

    /** @var string */
    public $default_shipping;

    /** @var string */
    public $created_at;

    /** @var string */
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

    /** @var array|AddressView[] */
    public $addresses;

    /** @var int */
    public $disable_auto_group_change;
}
