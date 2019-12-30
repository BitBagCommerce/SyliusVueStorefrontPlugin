<?php

declare(strict_types=1);

namespace Functional\Api;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class DeleteCartActionTest extends JsonApiTestCase
{
    public function test_deleting_cart_item(): void
    {
        $this->markTestIncomplete();

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

        $this->client->request('POST', sprintf('/vsbridge/cart/delete?token=%d&cartId=%d', $content->result, 12345), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_successful');
    }

    public function test_deleting_cart_item_for_blank_item(): void
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

        $this->client->request('POST', sprintf('/vsbridge/cart/delete?token=%d&cartId=%d', $content->result, 12345), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_blank_item', 500);
    }

    public function test_deleting_cart_item_for_non_existent_item(): void
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

        $data =
<<<JSON
        { 
            "cartItem": 
                { 
                    "sku": "Non-existent item",
                    "qty": 2,
                    "quoteId": "12345" 
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/delete?token=%d&cartId=%d',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_non_existent_item', 400);
    }
}
