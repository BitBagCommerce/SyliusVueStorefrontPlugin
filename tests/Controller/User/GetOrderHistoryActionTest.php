<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class GetOrderHistoryActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_getting_order_history(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $this->client->request('GET', sprintf(
            '/vsbridge/user/order-history?token=%s',
            $this->token
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/User/get_order_history_successful');
    }
}
