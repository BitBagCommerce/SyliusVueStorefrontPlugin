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

final class SetShippingMethodsActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_setting_shipping_methods(): void
    {
        $this->markTestIncomplete();

        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml', 'shipping.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $requestBody =
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

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/set_shipping_methods_successful', Response::HTTP_OK);
    }

    public function test_setting_shipping_methods_for_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            12345
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/blank_address', Response::HTTP_BAD_REQUEST);
    }

    public function test_setting_shipping_methods_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $uri = sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            12345,
            12345
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_token', Response::HTTP_UNAUTHORIZED);
    }

    public function test_setting_shipping_methods_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            123
        );

        $requestBody =
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

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_cart', Response::HTTP_BAD_REQUEST);
    }

    public function test_setting_shipping_information_for_invalid_cart_and_blank_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/shipping-methods?token=%s&cartId=%s',
            $this->token,
            123
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/Common/invalid_cart_and_blank_address', Response::HTTP_BAD_REQUEST);
    }
}
