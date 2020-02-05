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
use Elastica\Query\BoolQuery;
use Elastica\QueryBuilder\DSL\Query;
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
            $requestBody = \json_decode($queryParameters['request'], true);

            $boolQueryTerms = $requestBody['query']['bool']['filter']['terms'] ?? null;

            if (isset($boolQueryTerms['configurable_children.sku'])) {
                $sku = $boolQueryTerms['configurable_children.sku'][0];
            } elseif (isset($boolQueryTerms['sku'])) {
                $sku = $boolQueryTerms['sku'][0];
            }

            if (isset($sku)) {
                $boolQuery = new BoolQuery();

                $boolQuery->addShould(
                    (new Query())
                        ->term()->setParam('sku', $sku)
                );

                $boolQuery->addShould(
                    (new Query())
                        ->nested()
                        ->setPath('configurable_children')
                        ->setQuery((new Query())
                            ->term()->setParam('configurable_children.sku', $sku)
                        )
                );

                $requestBody['query'] = $boolQuery->toArray();
            }

            $requestBody = \json_encode($requestBody);

            unset($queryParameters['request']);
        }

        $elasticsearchResponse = $client->request($requestPath, Request::METHOD_GET, $requestBody, $queryParameters);

        return $this->viewHandler->handle(View::create($elasticsearchResponse->getData()));
    }
}
