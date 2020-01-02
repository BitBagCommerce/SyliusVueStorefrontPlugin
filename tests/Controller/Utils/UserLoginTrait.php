<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils;

use Symfony\Bundle\FrameworkBundle\Client;

trait UserLoginTrait
{
    /** @var Client */
    protected $client;
    private $token;

    private function authenticateUser(string $username, string $password)
    {
        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $this->token = $content->result;
    }
}
