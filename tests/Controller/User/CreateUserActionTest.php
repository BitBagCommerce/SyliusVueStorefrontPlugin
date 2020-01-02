<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;

final class CreateUserActionTest extends JsonApiTestCase
{
    public function test_creating_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $data =
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

        $this->client->request('POST', '/vsbridge/user/create', [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/create_user_successful');
    }

    public function test_creating_user_for_existing_account(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $data =
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

        $this->client->request('POST', '/vsbridge/user/create', [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/create_user_account_already_exists', 400);
    }

    public function test_creating_user_for_invalid_customer(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $data =
<<<JSON
        {
            "customer": {},
            "password": "SecretPassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/create', [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/create_user_invalid_customer', 400);
    }

    public function test_creating_user_for_blank_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml']);

        $data =
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

        $this->client->request('POST', '/vsbridge/user/create', [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/create_user_blank_password', 400);
    }
}
