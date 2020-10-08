<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Sylius\Factory;

use BitBag\SyliusVueStorefrontPlugin\Model\Request\Common\Address;
use BitBag\SyliusVueStorefrontPlugin\Model\Request\User\UserAddress;
use Sylius\Component\Core\Factory\AddressFactory as BaseAddressFactory;
use Sylius\Component\Core\Model\AddressInterface;
use Webmozart\Assert\Assert;

class AddressFactory extends BaseAddressFactory implements AddressFactoryInterface
{
    public function createFromDTO(Address $addressDTO): AddressInterface
    {
        /** @var AddressInterface $address */
        $address = $this->createNew();

        return $this->fillAddressData($address, $addressDTO);
    }

    public function fillAddressData(AddressInterface $address, Address $addressDTO): AddressInterface
    {
        $address->setCreatedAt(new \DateTime());

        $address->setStreet($addressDTO->getStreet());
        Assert::notNull($addressDTO->getStreet(), 'Customer has not provided street in request.');

        $address->setPostcode($addressDTO->getPostcode());
        Assert::notNull($addressDTO->getPostcode(), 'Customer has not provided postcode in request.');

        $address->setCity($addressDTO->getCity());
        Assert::notNull($addressDTO->getCity(), 'Customer has not provided city in request.');

        $address->setFirstName($addressDTO->getFirstName());
        Assert::notNull($addressDTO->getFirstName(), 'Customer has not provided a valid first name.');

        $address->setLastName($addressDTO->getLastName());
        Assert::notNull($addressDTO->getLastName(), 'Customer has not provided a valid last name.');

        $address->setCountryCode($addressDTO->getCountryId());

        if ($addressDTO instanceof UserAddress) {
            $address->setProvinceCode((string) $addressDTO->getRegionId());

            $address->setProvinceName((string) $addressDTO->region()->getRegion());
        }

        return $address;
    }
}
