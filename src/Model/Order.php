<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Model;

use Webmozart\Assert\Assert;

final class Order
{
    private const USER_ID = 'user_id';
    private const CART_ID = 'cart_id';
    private const ORDER_ID = 'order_id';
    private const PRODUCTS = 'products';
    private const ADDRESS_INFORMATION = 'addressInformation';
    private const TRANSMITTED = 'transmitted';
    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';

    /** @var string */
    private $userId;

    /** @var string */
    private $cartId;

    /** @var string */
    private $orderId;

    /** @var OrderProduct[] */
    private $products;

    /** @var AddressInformation */
    private $addressInformation;

    /** @var bool */
    private $transmitted;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    public function __construct(
        string $userId,
        string $cartId,
        string $orderId,
        OrderProduct $products,
        AddressInformation $addressInformation,
        bool $transmitted,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ) {
        $this->userId = $userId;
        $this->cartId = $cartId;
        $this->orderId = $orderId;
        $this->products = $products;
        $this->addressInformation = $addressInformation;
        $this->transmitted = $transmitted;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function createFromArray(array $order): self
    {
        Assert::keyExists($order, self::USER_ID);
        Assert::keyExists($order, self::CART_ID);
        Assert::keyExists($order, self::ORDER_ID);
        Assert::keyExists($order, self::PRODUCTS);
        Assert::keyExists($order, self::ADDRESS_INFORMATION);
        Assert::keyExists($order, self::TRANSMITTED);
        Assert::keyExists($order, self::CREATED_AT);
        Assert::keyExists($order, self::UPDATED_AT);

        return new self(
            $order[self::USER_ID],
            $order[self::CART_ID],
            $order[self::ORDER_ID],
            $order[self::PRODUCTS]->toArray(),
            AddressInformation::createFromArray($order[self::ADDRESS_INFORMATION]),
            $order[self::TRANSMITTED],
            $order[self::CREATED_AT],
            $order[self::UPDATED_AT]
        );
    }
}
