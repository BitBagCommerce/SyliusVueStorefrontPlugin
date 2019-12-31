<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\Cart;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class SetShippingInformationActionTest extends JsonApiTestCase
{
    public function test_setting_shipping_information(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml', 'shipping.yml']);

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
            "addressInformation":
                {
                    "shipping_address":
                        {
                            "id": 123,
                            "customer_id": 123,
                            "region": {
                              "region_code": null,
                              "region": null,
                              "region_id": 0
                            },
                            "region_id": 0,
                            "country_id": "PL",
                            "street": "GoodStreet",
                            "company": "BestCompany",
                            "telephone": "987654321",
                            "postcode": "22-567",
                            "city": "GoodCity",
                            "firstname": "John",
                            "lastname": "Doe",
                            "vat_id": "PL987654321"
                        },
                        "shipping_method_code":"FED-EX",
                        "shipping_carrier_code":"FED-EX"
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/set_shipping_information_successful', 200);
    }

    public function test_setting_shipping_information_for_non_existent_method(): void
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
            "addressInformation":
                {
                    "shipping_address":
                        {
                            "id": 123,
                            "customer_id": 123,
                            "region": {
                              "region_code": null,
                              "region": null,
                              "region_id": 0
                            },
                            "region_id": 0,
                            "country_id": "PL",
                            "street": "GoodStreet",
                            "company": "BestCompany",
                            "telephone": "987654321",
                            "postcode": "22-567",
                            "city": "GoodCity",
                            "firstname": "John",
                            "lastname": "Doe",
                            "vat_id": "PL987654321"
                        },
                        "shipping_method_code":"fedex",
                        "shipping_carrier_code":"fedex"
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/set_shipping_information_for_non_existent_method', 500);
    }

    public function test_setting_shipping_information_for_blank_address(): void
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

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/blank_address', 400);
    }

    public function test_setting_shipping_information_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            12345,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_setting_shipping_information_for_invalid_cart(): void
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
            "addressInformation":
                {
                    "shipping_address":
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
                            "street": "GoodStreet",
                            "company": "BestCompany",
                            "telephone": "987654321",
                            "postcode": "22-567",
                            "city": "GoodCity",
                            "firstname": "John",
                            "lastname": "Doe",
                            "vat_id": "PL987654321"
                        },
                        "shipping_method_code":"fedex",
                        "shipping_carrier_code":"fedex"
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $content->result,
            123
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }

    public function test_setting_shipping_information_for_invalid_cart_and_blank_address(): void
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

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $content->result,
            123
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart_and_blank_address', 400);
    }
}
