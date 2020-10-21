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
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

class AddressFactory extends BaseAddressFactory implements AddressFactoryInterface
{
    /** @var TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator, FactoryInterface $factory)
    {
        parent::__construct($factory);

        $this->translator = $translator;
    }

    public function createFromDTO(Address $addressDTO): AddressInterface
    {
        /** @var AddressInterface $address */
        $address = $this->createNew();

        return $this->fillAddressData($address, $addressDTO);
    }

    public function fillAddressData(AddressInterface $address, Address $addressDTO): AddressInterface
    {
        $address->setCreatedAt(new \DateTime());

        Assert::notNull(
            $addressDTO->getStreet(),
            $this->translator->trans(
                'bitbag.vue_storefront_api.sylius.user.address.street.not_null',
                [],
                'validators'
            )
        );
        $address->setStreet($addressDTO->getStreet());

        Assert::notNull(
            $addressDTO->getPostcode(),
            $this->translator->trans(
                'bitbag.vue_storefront_api.sylius.user.address.postcode.not_null',
                [],
                'validators'
            )
        );
        $address->setPostcode($addressDTO->getPostcode());

        Assert::notNull(
            $addressDTO->getCity(),
            $this->translator->trans(
                'bitbag.vue_storefront_api.sylius.user.address.city.not_null',
                [],
                'validators'
            )
        );
        $address->setCity($addressDTO->getCity());

        Assert::notNull(
            $addressDTO->getFirstName(),
            $this->translator->trans(
                'bitbag.vue_storefront_api.sylius.user.address.firstname.not_null',
                [],
                'validators'
            )
        );
        $address->setFirstName($addressDTO->getFirstName());

        Assert::notNull(
            $addressDTO->getLastName(),
            $this->translator->trans(
                'bitbag.vue_storefront_api.sylius.user.address.firstname.not_null',
                [],
                'validators'
            )
        );
        $address->setLastName($addressDTO->getLastName());

        $address->setCountryCode($addressDTO->getCountryId());

        if ($addressDTO instanceof UserAddress) {
            $address->setProvinceCode((string) $addressDTO->getRegionId());

            $address->setProvinceName((string) $addressDTO->region()->getRegion());
        }

        return $address;
    }
}
