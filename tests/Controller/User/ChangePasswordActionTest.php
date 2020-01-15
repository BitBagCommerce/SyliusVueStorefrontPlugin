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

final class ChangePasswordActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_changing_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "currentPassword": "MegaSafePassword",
            "newPassword": "MoreSafePassword"
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/change_password_successful');
    }

    public function test_changing_password_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $uri = sprintf(
            '/vsbridge/user/change-password?token=%s',
            12345
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/Common/invalid_token', Response::HTTP_UNAUTHORIZED);
    }

    public function test_changing_password_for_invalid_current_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "currentPassword": "InvalidPassword",
            "newPassword": "MoreSafePassword"
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/change_password_invalid_current_password', Response::HTTP_BAD_REQUEST);
    }

    public function test_changing_password_for_blank_new_password(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/change-password?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "currentPassword": "MegaSafePassword",
            "newPassword": ""
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/change_password_blank_new_password', Response::HTTP_BAD_REQUEST);
    }
}
