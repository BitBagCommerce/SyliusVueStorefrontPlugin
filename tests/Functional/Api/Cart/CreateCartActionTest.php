<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\Cart;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class CreateCartActionTest extends JsonApiTestCase
{
    public function test_creating_cart_for_guest_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('POST', '/vsbridge/cart/create', [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/create_cart_successful');
    }

    public function test_creating_cart_for_authorized_user(): void
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

        $this->client->request('POST', sprintf('/vsbridge/cart/create?token=%s', $content->result), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/create_cart_successful');
    }
}
