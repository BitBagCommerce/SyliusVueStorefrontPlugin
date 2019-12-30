<?php

/*
 * This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\Command\User;

use BitBag\SyliusVueStorefrontPlugin\Command\User\UpdateUser;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\ExistingUser;
use PhpSpec\ObjectBehavior;

/**
 * @todo SPEC
 * Class UpdateUserSpec
 */
final class UpdateUserSpec extends ObjectBehavior
{
    /** @var ExistingUser */
    private $customer;

    public function let(): void
    {
        $this->beConstructedWith(
            $this->customer = $this->getExistingUserMock()
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdateUser::class);
    }

    private function getExistingUserMock(): ExistingUser
    {
        return ExistingUser::createFromArray([
            'id' => 1,
            'group_id' => 2,
            'default_billing' => 'example',
            'default_shipping' => 'example',
            'created_at' => 'now',
            'updated_at' => 'now',
            'created_in' => 'example',
            'email' => 'shop@example.com',
            'firstname' => 'Katarzyna',
            'lastname' => 'Nosowska',
            'store_id' => 3,
            'website_id' => 4,
            'addresses' => [
                1 => [
                    'id' => 1,
                    'customer_id' => 1,
                    'region' => [
                        'region_code' => 'example-code',
                        'region' => 'example-region',
                        'region_id' => 1,
                    ],
                    'region_id' => 1,
                    'country_id' => 'country',
                    'street' => 'example-street',
                    'company' => 'example',
                    'telephone' => '987 654 321',
                    'postcode' => '12345',
                    'city' => 'example-city',
                    'firstname' => 'Katarzyna',
                    'lastname' => 'Nosowska',
                    'vat_id' => 'example-id',
                ],
                2 => [
                    'id' => 1,
                    'customer_id' => 1,
                    'region' => [
                        'region_code' => 'example-code',
                        'region' => 'example-region',
                        'region_id' => 1,
                    ],
                    'region_id' => 1,
                    'country_id' => 'country',
                    'street' => 'example-street',
                    'company' => 'example',
                    'telephone' => '987 654 321',
                    'postcode' => '12345',
                    'city' => 'example-city',
                    'firstname' => 'Katarzyna',
                    'lastname' => 'Nosowska',
                    'vat_id' => 'example-id',
                ],
            ],
            'disable_auto_group_change' => 1,
        ]);
    }
}
