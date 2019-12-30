<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class DeleteCouponActionTest extends JsonApiTestCase
{
    public function test_deleting_coupon(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%d',
            $content->result,
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
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%d',
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

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%s&cartId=%d',
            $content->result,
            123
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }
}
