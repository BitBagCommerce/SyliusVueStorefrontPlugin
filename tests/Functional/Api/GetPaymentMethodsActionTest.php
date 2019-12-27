<?php

declare(strict_types=1);

namespace Functional\Api;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class GetPaymentMethodsActionTest extends JsonApiTestCase
{
    public function test_getting_payment_methods(): void
    {
        $this->markTestIncomplete();

        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('GET', '/vsbridge/cart/payment-methods', [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/get_payment_methods_successful');
    }
}
