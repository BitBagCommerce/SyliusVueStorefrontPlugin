<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class SetShippingInformationActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_setting_shipping_information(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml', 'shipping.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $requestBody =
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
                            "street": ["GoodStreet","10"],
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

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/set_shipping_information_successful', Response::HTTP_OK);
    }

    public function test_setting_shipping_information_for_non_existent_method(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $requestBody =
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
                            "street": ["GoodStreet","10"],
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

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse(
            $response,
            'Controller/Cart/set_shipping_information_non_existent_method',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public function test_setting_shipping_information_for_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/blank_address', Response::HTTP_BAD_REQUEST);
    }

    public function test_setting_shipping_information_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            12345,
            12345
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_token', Response::HTTP_UNAUTHORIZED);
    }

    public function test_setting_shipping_information_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $this->token,
            123
        );

        $requestBody =
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
                            "street": ["GoodStreet","10"],
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

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_cart', Response::HTTP_BAD_REQUEST);
    }

    public function test_setting_shipping_information_for_invalid_cart_and_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-information?token=%s&cartId=%s',
            $this->token,
            123
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_cart_and_blank_address', Response::HTTP_BAD_REQUEST);
    }
}
