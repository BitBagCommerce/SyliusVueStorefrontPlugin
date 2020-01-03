<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class SetShippingMethodsActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_setting_shipping_methods(): void
    {
        $this->markTestIncomplete();

        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml', 'shipping.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $data =
<<<JSON
        {
            "address":
                {
                    "id": 123,
                    "customer_id": 123,
                    "region": {
                      "region_code": null,
                      "region": null,
                      "region_id": 0
                    },
                    "region_id": 0,
                    "country_id": "GB",
                    "street": ["GoodStreet","10"],
                    "company": "BestCompany",
                    "telephone": "987654321",
                    "postcode": "22-567",
                    "city": "GoodCity",
                    "firstname": "John",
                    "lastname": "Doe",
                    "vat_id": "PL987654321"
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/set_shipping_methods_successful', 200);
    }

    public function test_setting_shipping_methods_for_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/blank_address', 400);
    }

    public function test_setting_shipping_methods_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            12345,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_setting_shipping_methods_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $data =
<<<JSON
        {
            "address":
                {
                    "id": 123,
                    "customer_id": 123,
                    "region": {
                      "region_code": null,
                      "region": null,
                      "region_id": 0
                    },
                    "region_id": 0,
                    "country_id": "GB",
                    "street": ["GoodStreet","10"],
                    "company": "BestCompany",
                    "telephone": "987654321",
                    "postcode": "22-567",
                    "city": "GoodCity",
                    "firstname": "John",
                    "lastname": "Doe",
                    "vat_id": "PL987654321"
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            123
        ), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }

    public function test_setting_shipping_information_for_invalid_cart_and_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            123
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart_and_blank_address', 400);
    }
}
