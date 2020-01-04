<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;

final class ResetPasswordActionTest extends JsonApiTestCase
{
    public function test_resetting_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $data =
<<<JSON
        {
            "email": "test@example.com"
        }
JSON;

        $this->client->request('POST', sprintf('/vsbridge/user/reset-password'), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/reset_password_successful');
    }

    public function test_resetting_password_for_invalid_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $data =
<<<JSON
        {
            "email": "invalid@email.com"
        }
JSON;

        $this->client->request('POST', sprintf('/vsbridge/user/reset-password'), [], [], self::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/reset_password_invalid_user', 500);
    }
}
