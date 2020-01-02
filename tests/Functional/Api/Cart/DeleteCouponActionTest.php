<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\Cart;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\UserLoginTrait;

final class DeleteCouponActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_deleting_coupon(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_coupon_successful');
    }

    public function test_deleting_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%s',
            12345,
            12345
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_deleting_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%s',
            $this->token,
            123
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }
}
