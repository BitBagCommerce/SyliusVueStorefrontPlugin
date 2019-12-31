<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Api\Cart;

use ApiTestCase\JsonApiTestCase;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Tests\BitBag\SyliusVueStorefrontPlugin\Functional\Configuration;

final class DeleteCartActionTest extends JsonApiTestCase
{
    public function test_deleting_cart_item(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'order_item.yml', 'coupon_based_promotion.yml', 'product_with_attributes.yml']);

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $orderRepository = $this->client->getContainer()->get('sylius.repository.order');
        $orderItemRepository = $this->client->getContainer()->get('sylius.repository.order_item');

        /** @var OrderInterface $order */
        $order = $orderRepository->findOneBy(['tokenValue' => '12345']);

        /** @var OrderItemInterface $orderItem */
        $orderItem = $orderItemRepository->findOneByOrder($order);
        $id = $orderItem->getId();

        $data =
<<<JSON
        { 
            "cartItem": 
                { 
                    "sku": "RANDOM_JACKET_CODE",
                    "qty": 1,
                    "item_id": $id,
                    "quoteId": "12345" 
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/delete?token=%s&cartId=%s',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_successful');
    }

    public function test_deleting_cart_item_for_blank_item(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $this->client->request('POST', sprintf('/vsbridge/cart/delete?token=%s&cartId=%s', $content->result, 12345), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_blank_item', 500);
    }

    public function test_deleting_cart_item_for_non_existent_item(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $data =
<<<JSON
        { 
            "cartItem": 
                { 
                    "sku": "Non-existent item",
                    "qty": 2,
                    "quoteId": "12345" 
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/delete?token=%s&cartId=%s',
            $content->result,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/delete_cart_item_non_existent_item', 400);
    }

    public function test_deleting_cart_item_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/delete?token=%s&cartId=%s',
            12345,
            12345
        ), [], [], Configuration::CONTENT_TYPE_HEADER);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_token', 401);
    }

    public function test_deleting_cart_item_for_invalid_cart(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'order.yml', 'coupon_based_promotion.yml']);

        $data =
<<<JSON
        {
            "username": "test@example.com",
            "password": "MegaSafePassword"
        }
JSON;

        $this->client->request('POST', '/vsbridge/user/login', [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        $content = json_decode($response->getContent());

        $data =
<<<JSON
        { 
            "cartItem": 
                { 
                    "sku": "Non-existent item",
                    "qty": 2,
                    "quoteId": "123" 
                }
        }
JSON;

        $this->client->request('POST', sprintf(
            '/vsbridge/cart/delete?token=%s&cartId=%s',
            $content->result,
            123
        ), [], [], Configuration::CONTENT_TYPE_HEADER, $data);

        $response = $this->client->getResponse();

        self::assertResponse($response, 'Controller/Cart/Common/invalid_cart', 400);
    }
}
