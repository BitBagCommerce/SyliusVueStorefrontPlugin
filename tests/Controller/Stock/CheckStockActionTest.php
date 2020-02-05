<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Stock;

use Symfony\Component\HttpFoundation\Request;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;

final class CheckStockActionTest extends JsonApiTestCase
{
    public function test_checking_stock_of_product_variant(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'product_with_attributes.yaml']);

        $uri = sprintf(
            '/vsbridge/stock/check?sku=%s',
            'RANDOM_JACKET_CODE'
        );

        $this->request(Request::METHOD_GET, $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Stock/check_stock_successful', 200);
    }

    public function test_checking_stock_of_invalid_product_variant(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'product_with_attributes.yaml']);

        $uri = sprintf(
            '/vsbridge/stock/check?sku=%s',
            'INVALID_PRODUCT_VARIANT'
        );

        $this->request(Request::METHOD_GET, $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Stock/check_stock_invalid_product_variant', 404);
    }

    public function test_checking_out_of_stock_of_product_variant(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'product_with_attributes.yaml']);

        $uri = sprintf(
            '/vsbridge/stock/check?sku=%s',
            'RANDOM_SECOND_JACKET_CODE'
        );

        $this->request(Request::METHOD_GET, $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Stock/check_stock_out_of_stock', 200);
    }
}
