<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Provider;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;
use Sylius\Component\Core\Factory\AddressFactoryInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Webmozart\Assert\Assert;

final class AddressProvider implements AddressProviderInterface
{
    /** @var AddressFactoryInterface */
    private $addressFactory;

    public function __construct(AddressFactoryInterface $addressFactory)
    {
        $this->addressFactory = $addressFactory;
    }

    public function provide(Address $requestAddress): AddressInterface
    {
        /** @var AddressInterface $address */
        $address = $this->addressFactory->createNew();

        $address->setCreatedAt(new \DateTime());

        $address->setStreet($requestAddress->getStreet());
        Assert::notNull($requestAddress->getStreet(), 'Customer has not provided street in request.');

        $address->setPostcode($requestAddress->getPostcode());
        Assert::notNull($requestAddress->getPostcode(), 'Customer has not provided postcode in request.');

        $address->setCity($requestAddress->getCity());
        Assert::notNull($requestAddress->getCity(), 'Customer has not provided city in request.');

        $address->setFirstName($requestAddress->getFirstName());
        Assert::notNull($requestAddress->getFirstName(), 'Customer has not provided a valid first name.');

        $address->setLastName($requestAddress->getLastName());
        Assert::notNull($requestAddress->getLastName(), 'Customer has not provided a valid last name.');

        $address->setCountryCode($requestAddress->getCountryId());

        return $address;
    }
}
