<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusVueStorefrontPlugin\Controller\User;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\JsonApiTestCase;
use Tests\BitBag\SyliusVueStorefrontPlugin\Controller\Utils\UserLoginTrait;

final class UpdateUserActionTest extends JsonApiTestCase
{
    use UserLoginTrait;

    public function test_updating_user(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->client->getContainer()->get('sylius.repository.shop_user');

        /** @var ShopUserInterface $shopUser */
        $shopUser = $userRepository->findOneByEmail('test@example.com');

        $customerId = $shopUser->getCustomer()->getId();

        $requestBody =
<<<JSON
        {
            "customer": {
                "id": $customerId,
                "group_id": 1,
                "default_billing": "10",
                "default_shipping": "10",
                "created_at": "2018-03-16 19:01:18",
                "updated_at": "2018-04-03 12:59:13",
                "created_in": "Fashion Web",
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe",
                "store_id": 1,
                "website_id": 1,
                "addresses": [
                    {
                        "id": 123,
                        "customer_id": 123,
                        "region": {
                          "region_code": null,
                          "region": null,
                          "region_id": 0
                        },
                        "region_id": 0,
                        "country_id": "GB",
                        "street": ["GoodStreet","10"],
                        "company": "BestCompany",
                        "telephone": "987654321",
                        "postcode": "22-567",
                        "city": "GoodCity",
                        "firstname": "John",
                        "lastname": "Doe",
                        "vat_id": "PL987654321"
                    }
                ],
                "disable_auto_group_change": 0
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/update_user_successful');
    }

    public function test_updating_user_if_invalid(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            $this->token
        );

        $requestBody =
<<<JSON
        {
            "customer": {
                "id": 123,
                "group_id": 1,
                "default_billing": "10",
                "default_shipping": "10",
                "created_at": "2018-03-16 19:01:18",
                "updated_at": "2018-04-03 12:59:13",
                "created_in": "Fashion Web",
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe",
                "store_id": 1,
                "website_id": 1,
                "addresses": [
                    {
                        "id": 123,
                        "customer_id": 123,
                        "region": {
                          "region_code": null,
                          "region": null,
                          "region_id": 0
                        },
                        "region_id": 0,
                        "country_id": "GB",
                        "street": ["GoodStreet","10"],
                        "company": "BestCompany",
                        "telephone": "987654321",
                        "postcode": "22-567",
                        "city": "GoodCity",
                        "firstname": "John",
                        "lastname": "Doe",
                        "vat_id": "PL987654321"
                    }
                ],
                "disable_auto_group_change": 0
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/update_user_invalid_user', Response::HTTP_BAD_REQUEST);
    }

    public function test_updating_user_for_invalid_token(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml']);

        $this->authenticateUser('test@example.com', 'MegaSafePassword');

        $uri = sprintf(
            '/vsbridge/user/me?token=%s',
            123
        );

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->client->getContainer()->get('sylius.repository.shop_user');

        /** @var ShopUserInterface $shopUser */
        $shopUser = $userRepository->findOneByEmail('test@example.com');

        $customerId = $shopUser->getCustomer()->getId();

        $requestBody =
<<<JSON
        {
            "customer": {
                "id": $customerId,
                "group_id": 1,
                "default_billing": "10",
                "default_shipping": "10",
                "created_at": "2018-03-16 19:01:18",
                "updated_at": "2018-04-03 12:59:13",
                "created_in": "Fashion Web",
                "email": "test@example.com",
                "firstname": "Johny",
                "lastname": "Doe",
                "store_id": 1,
                "website_id": 1,
                "addresses": [
                    {
                        "id": 123,
                        "customer_id": 123,
                        "region": {
                          "region_code": null,
                          "region": null,
                          "region_id": 0
                        },
                        "region_id": 0,
                        "country_id": "GB",
                        "street": ["GoodStreet","10"],
                        "company": "BestCompany",
                        "telephone": "987654321",
                        "postcode": "22-567",
                        "city": "GoodCity",
                        "firstname": "John",
                        "lastname": "Doe",
                        "vat_id": "PL987654321"
                    }
                ],
                "disable_auto_group_change": 0
            }
        }
JSON;

        $this->request(Request::METHOD_POST, $uri, self::JSON_REQUEST_HEADERS, $requestBody);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Controller/User/Common/invalid_token', Response::HTTP_UNAUTHORIZED);
    }
}
