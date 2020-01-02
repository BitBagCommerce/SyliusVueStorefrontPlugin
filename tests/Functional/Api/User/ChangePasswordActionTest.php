<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\User;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\UserLoginTrait;

final class UpdateCartActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_changing_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $data =
<<<JSON
        {
            "currentPassword": "MegaSafePassword",
            "newPassword": "MoreSafePassword"
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/change_password_successful');
    }

    public function test_changing_password_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->client->request('POST', sprintf(
            '/vsbridge/user/change-password?token=%s',
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/Common/invalid_token', 401);
    }

    public function test_changing_password_for_invalid_current_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $data =
<<<JSON
        {
            "currentPassword": "InvalidPassword",
            "newPassword": "MoreSafePassword"
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/change_password_invalid_current_password', 400);
    }

    public function test_changing_password_for_blank_new_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $data =
<<<JSON
        {
            "currentPassword": "MegaSafePassword",
            "newPassword": ""
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/change_password_blank_new_password', 400);
    }
}
