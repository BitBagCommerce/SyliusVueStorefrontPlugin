<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class SyncTotalsActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_synchronizing_totals(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $this->client->request('GET', sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/sync_totals_successful');
    }

    public function test_synchronizing_totals_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('GET', sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            12345,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_synchronizing_totals_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $this->client->request('GET', sprintf(
            '/vsbridge/cart/totals?token=%s&cartId=%s',
            $this->token,
            123
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }
}
