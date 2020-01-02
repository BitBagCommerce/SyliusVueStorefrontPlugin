<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Cart;

use BitBag\SyliusVueStorefrontPlugin\Command\Cart\SetShippingInformation;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Handler\ShipmentHandlerInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Modifier\DefaultAddressModifierInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\AddressProviderInterface;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class SetShippingInformationHandler implements MessageHandlerInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ShippingMethodRepositoryInterface $shippingMethodRepository */
    private $shippingMethodRepository;

    /** @var ObjectManager $entityManager */
    private $entityManager;

    /** @var AddressProviderInterface */
    private $addressProvider;

    /** @var DefaultAddressModifierInterface */
    private $addressModifier;

    /** @var ShipmentHandlerInterface */
    private $shipmentHandler;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        AddressProviderInterface $addressProvider,
        DefaultAddressModifierInterface $addressModifier,
        ShipmentHandlerInterface $shipmentHandler,
        ObjectManager $entityManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->addressProvider = $addressProvider;
        $this->addressModifier = $addressModifier;
        $this->shipmentHandler = $shipmentHandler;
        $this->entityManager = $entityManager;
    }

    public function __invoke(SetShippingInformation $setShippingInformation): void
    {
        /** @var OrderInterface $cart */
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $setShippingInformation->cartId(), 'shippingState' => OrderInterface::STATE_CART]);
        Assert::notNull($cart, sprintf('Cart with token value of %s has not been found.', $setShippingInformation->cartId()));

        /** @var CustomerInterface $customer */
        $customer = $cart->getCustomer();
        Assert::notNull($customer, sprintf('Cart `%s` has no valid customer assigned.', $cart->getTokenValue()));

        $address = $this->addressProvider->provide($customer, $setShippingInformation);

        $this->addressModifier->modify($customer, $address);

        $cart->setShippingAddress($address);

        /** @var ShippingMethodInterface $shippingMethod */
        $shippingMethod = $this->shippingMethodRepository->findOneBy(['code' => $setShippingInformation->addressInformation()->getShippingCarrierCode(), 'enabled' => 1]);
        Assert::notNull($shippingMethod, sprintf('Shipping method with code value of %s has not been found.', $setShippingInformation->addressInformation()->getShippingCarrierCode()));

        $this->shipmentHandler->handle($cart, $shippingMethod);

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}
