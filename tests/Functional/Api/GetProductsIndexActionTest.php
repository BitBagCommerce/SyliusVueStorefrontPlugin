<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api;

use ApiTestCase\JsonApiTestCase;

final class GetProductsIndexActionTest extends JsonApiTestCase
{
    public function test_returning_a_full_list_of_products(): void
    {
        $this->client->request('GET', '/vsbridge/products/index');

        $response = $this->client->getResponse();

        self::assertResponse($response, 'products_index_successfull');
    }
}
