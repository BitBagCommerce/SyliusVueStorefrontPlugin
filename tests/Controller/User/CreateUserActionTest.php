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

final class CreateUserActionTest extends JsonApiTestCase
{
    public function test_creating_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "nice@email.com",
                "firstname": "John",
                "lastname": "Doe"
            },
            "password": "SecretPassword"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/create', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/create_user_successful');
    }

    public function test_creating_user_for_existing_account(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "test@example.com",
                "firstname": "John",
                "lastname": "Nowak"
            },
            "password": "SecretPassword"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/create', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/create_user_account_already_exists', Response::HTTP_BAD_REQUEST);
    }

    public function test_creating_user_for_invalid_customer(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $requestBody =
<<<JSON
        {
            "customer": {},
            "password": "SecretPassword"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/create', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/create_user_invalid_customer', Response::HTTP_BAD_REQUEST);
    }

    public function test_creating_user_for_blank_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $requestBody =
<<<JSON
        {
            "customer": {
                "email": "nice@email.com",
                "firstname": "John",
                "lastname": "Doe"
            },
            "password": ""
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/create', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/create_user_blank_password', Response::HTTP_BAD_REQUEST);
    }
}
