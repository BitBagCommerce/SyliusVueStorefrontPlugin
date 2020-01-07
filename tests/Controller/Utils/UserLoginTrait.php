<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Request;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;

trait UserLoginTrait
{
    /** @var Client */
    protected $client;

    /** @var string */
    private $token;

    private function authenticateUser(string $username, string $password): void
    {
        $requestBody =
<<<JSON
        {
            "username": "$username",
            "password": "$password"
        }
JSON;

        $this->request(Request::METHOD_POST, '/vsbridge/user/login', JsonApiTestCase::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $this->token = $content->result;
    }
}
