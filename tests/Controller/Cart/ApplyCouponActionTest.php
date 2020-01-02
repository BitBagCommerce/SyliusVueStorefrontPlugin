<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;


use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class ApplyCouponActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_applying_coupon(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/apply-coupon?token=%s&cartId=%s&coupon=SOMETHING',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/apply_coupon_successful', 200);
    }

    public function test_applying_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $uri = sprintf(
            '/vsbridge/cart/apply-coupon?token=%s&cartId=%s&coupon=SOMETHING',
            12345,
            12345
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_applying_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $uri = sprintf(
            '/vsbridge/cart/apply-coupon?token=%s&cartId=%s&coupon=SOMETHING',
            $this->token,
            123
        );

        $this->client->request('POST', $uri);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }

    public function test_applying_for_blank_coupon(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/apply-coupon?token=%s&cartId=%s',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/apply_coupon_blank_coupon', 400);
    }

    public function test_applying_for_invalid_coupon(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->authenticateUser("test@example.com", "MegaSafePassword");

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/apply-coupon?token=%s&cartId=%s&coupon=INVALID',
            $this->token,
            12345
        ), [], [], self::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/apply_coupon_invalid_coupon', 400);
    }
}
