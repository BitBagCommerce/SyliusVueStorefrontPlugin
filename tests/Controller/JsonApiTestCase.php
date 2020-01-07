<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller;

use ApiTestCase\JsonApiTestCase as BaseJsonApiTestCase;

abstract class JsonApiTestCase extends BaseJsonApiTestCase
{
    public const JSON_REQUEST_HEADERS = ['CONTENT_TYPE' => 'application/json', 'ACCEPT' => 'application/json'];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataFixturesPath = __DIR__ . '/../DataFixtures/ORM';
        $this->expectedResponsesPath = __DIR__ . '/../Responses/json';
    }

    protected function request(
        string $method,
        string $uri,
        array $server = [],
        string $requestBody = null,
        array $parameters = [],
        array $files = []
    ): void {
        $this->client->request($method, $uri, $parameters, $files, $server, $requestBody);
    }
}
