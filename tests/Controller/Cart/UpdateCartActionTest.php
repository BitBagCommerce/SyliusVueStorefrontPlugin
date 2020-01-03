<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class UpdateCartActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_updating_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml', 'product_with_attributes.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $data =
<<<JSON
        { 
            "cartItem": 
                { 
                    "sku": "RANDOM_JACKET_CODE",
                    "qty": 2,
                    "quoteId": "12345" 
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/update?token=%s&cartId=%s&coupon=SOMETHING',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/update_cart_successful', 200);
    }

    public function test_updating_cart_for_non_existent_cart_item(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $data =
<<<JSON
        { "cartItem": 
            { 
                "sku": "Non-existent item",
                "qty": 2,
                "quoteId": "12345" 
            }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/update?token=%s&cartId=%s&coupon=SOMETHING',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/update_cart_non_existent_item', 500);
    }

    public function test_updating_cart_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $uri = sprintf(
            '/vsbridge/cart/update?token=%s&cartId=%s&coupon=SOMETHING',
            12345,
            12345
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_updating_cart_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/update?token=%s&cartId=%s&coupon=SOMETHING',
            $this->token,
            123
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }
}
