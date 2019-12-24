<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api;

use ApiTestCase\JsonApiTestCase;

final class DeleteCouponActionTest extends JsonApiTestCase
{
    public function test_deleting_coupon(): void
    {
        $suite = $this->client->getContainer()->get('sylius_fixtures.suite_registry')->getSuite('default');
        $this->client->getContainer()->get('sylius_fixtures.suite_loader')->load($suite);

        $content = [
            'username' => 'test@example.com',
            'password' => 'MegaSafePassword',
        ];

        $this->client->request('POST', '/vsbridge/user/login', [], [], [], json_encode($content));

        $response = $this->client->getResponse();

        $token = json_decode($response->getContent(), true);

        $uri = sprintf(
            '/vsbridge/cart/delete-coupon?token=%d&cartId=%d',
            $token['result'],
            12345
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Cart/delete_coupon_successful');
    }
}
