<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\Cart;

use ApiTestCase\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\UserLoginTrait;

final class CreateCartActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_creating_cart_for_guest_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('POST', '/vsbridge/cart/create', [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/create_cart_successful');
    }

    public function test_creating_cart_for_authorized_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/create?token=%s',
            $this->token
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/create_cart_successful');
    }
}
