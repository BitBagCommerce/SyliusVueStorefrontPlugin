<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Cart;

use Symfony\Component\HttpFoundation\Request;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class CreateCartActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_creating_cart_for_guest_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml', 'order.yaml', 'coupon_based_promotion.yaml']);

        $this->request(Request::METHOD_POST, '/vsbridge/cart/create', self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/create_cart_successful');
    }

    public function test_creating_cart_for_authorized_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yaml', 'customer.yaml', 'order.yaml', 'coupon_based_promotion.yaml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/cart/create?token=%s',
            $this->token
        );

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/Cart/create_cart_successful');
    }
}
