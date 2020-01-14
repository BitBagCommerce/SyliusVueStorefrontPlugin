<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller\Catalog;

use Elastica\Client;
use Elastica\Connection;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetCatalogAction
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    public function __construct(ViewHandlerInterface $viewHandler, string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $client = new Client();
        $client->addConnection(new Connection(['host' => $this->host, 'port' => $this->port]));

        $index = $request->attributes->get('index');
        $type = $request->attributes->get('type');

        if (null === $type) {
            $requestPath = sprintf('%s/_search', $index);
        } else {
            $requestPath = sprintf('%s_%s/%s/_search', $index, $type, $type);
        }

        $queryParameters = $request->query->all();

        $requestBody = [];

        if (isset($queryParameters['request'])) {
            $requestBody = $queryParameters['request'];
            unset($queryParameters['request']);
        }

        $elasticsearchResponse = $client->request($requestPath, Request::METHOD_GET, $requestBody, $queryParameters);

        return $this->viewHandler->handle(View::create($elasticsearchResponse->getData()));
    }
}
