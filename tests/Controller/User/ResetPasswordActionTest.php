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

final class ResetPasswordActionTest extends JsonApiTestCase
{
    public function test_resetting_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $requestBody =
<<<JSON
        {
            "email": "test@example.com"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/reset-password', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/reset_password_successful');
    }

    public function test_resetting_password_for_invalid_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $requestBody =
<<<JSON
        {
            "email": "invalid@email.com"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/reset-password', self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/reset_password_invalid_user', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
