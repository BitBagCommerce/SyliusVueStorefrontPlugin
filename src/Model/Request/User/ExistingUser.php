<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model\Request\User;

use BitBag\SyliusVueStorefrontPlugin\Model\Response\Address;

final class ExistingUser
{
    private const ID = 'id';
    private const GROUP_ID = 'group_id';
    private const DEFAULT_BILLING = 'default_billing';
    private const DEFAULT_SHIPPING = 'default_shipping';
    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';
    private const CREATED_IN = 'created_in';
    private const EMAIL = 'email';
    private const FIRST_NAME = 'firstname';
    private const LAST_NAME = 'lastname';
    private const STORE_ID = 'store_id';
    private const WEBSITE_ID = 'website_id';
    private const ADDRESSES = 'addresses';
    private const DISABLE_AUTOMATIC_GROUP_CHANGE = 'disable_auto_group_change';

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var int */
    private $id;

    /** @var int */
    private $groupId;

    /** @var string|null */
    private $defaultBilling;

    /** @var string|null */
    private $defaultShipping;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var string */
    private $createdIn;

    /** @var string */
    private $email;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var int */
    private $storeId;

    /** @var int */
    private $websiteId;

    /** @var Address[] */
    private $addresses;

    /** @var int */
    private $disableAutomaticGroupChange;

    public function __construct(
        int $id,
        int $groupId,
        ?string $defaultBilling,
        ?string $defaultShipping,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        string $createdIn,
        string $email,
        string $firstName,
        string $lastName,
        int $storeId,
        int $websiteId,
        array $addresses,
        int $disableAutomaticGroupChange
    ) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->defaultBilling = $defaultBilling;
        $this->defaultShipping = $defaultShipping;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->createdIn = $createdIn;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->storeId = $storeId;
        $this->websiteId = $websiteId;
        $this->addresses = $addresses;
        $this->disableAutomaticGroupChange = $disableAutomaticGroupChange;
    }
}
