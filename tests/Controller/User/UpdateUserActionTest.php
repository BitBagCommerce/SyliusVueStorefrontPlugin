<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class UpdateUserActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_updating_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe",
                "addresses": [
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
                ]
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/update_user_successful');
    }

    public function test_updating_user_if_invalid(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "test@example.com",
                "firstname": "",
                "lastname": "Doe",
                "addresses": [
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
                ]
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse(
            $response,
            'Controller/User/update_user_invalid_user',
            Response::HTTP_BAD_REQUEST
        );
    }

    public function test_updating_user_for_blank_information(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        self::assertResponse(
            $response,
            'Controller/User/update_user_blank_information',
            Response::HTTP_BAD_REQUEST
        );
    }

    public function test_updating_user_for_blank_addresses(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe"
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        self::assertResponse(
            $response,
            'Controller/User/update_user_blank_addresses',
            Response::HTTP_BAD_REQUEST
        );
    }

    public function test_updating_user_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            123
        );

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe",
                "addresses": [
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
                ]
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse(
            $response,
            'Controller/User/Common/invalid_token',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
