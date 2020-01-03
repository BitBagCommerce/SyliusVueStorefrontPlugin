<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\CommandHandler\Order;

use BitBag\SyliusVueStorefrontPlugin\Command\Order\CreateOrder;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\ChannelProviderInterface;
use BitBag\SyliusVueStorefrontPlugin\Sylius\Provider\CustomerProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Currency\Context\CurrencyContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Shipping\Model\ShippingMethod;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateOrderHandler implements MessageHandlerInterface
{
    /** @var FactoryInterface */
    private $orderFactory;

    /** @var FactoryInterface */
    private $orderItemFactory;

    /** @var FactoryInterface */
    private $shipmentFactory;

    /** @var FactoryInterface */
    private $paymentFactory;

    /** @var OrderRepositoryInterface */
    private $cartRepository;

    /** @var ChannelProviderInterface */
    private $channelProvider;

    /** @var CustomerProviderInterface */
    private $customerProvider;

    /** @var CurrencyContextInterface */
    private $currency;

    /** @var LocaleContextInterface */
    private $localContext;

    /** @var OrderProcessorInterface */
    private $orderProcessor;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var ShippingMethodRepositoryInterface */
    private $shippingMethodRepository;

    /** @var PaymentMethodRepositoryInterface */
    private $paymentMethodRepository;

    public function __construct(
        FactoryInterface $orderFactory,
        FactoryInterface $orderItemFactory,
        FactoryInterface $shipmentFactory,
        FactoryInterface $paymentFactory,
        OrderRepositoryInterface $cartRepository,
        ChannelProviderInterface $channelProvider,
        CustomerProviderInterface $customerProvider,
        CurrencyContextInterface $currency,
        LocaleContextInterface $localContext,
        OrderProcessorInterface $orderProcessor,
        ProductVariantRepositoryInterface $productVariantRepository,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        PaymentMethodRepositoryInterface $paymentMethodRepository
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderItemFactory = $orderItemFactory;
        $this->shipmentFactory = $shipmentFactory;
        $this->paymentFactory = $paymentFactory;
        $this->cartRepository = $cartRepository;
        $this->channelProvider = $channelProvider;
        $this->customerProvider = $customerProvider;
        $this->currency = $currency;
        $this->localContext = $localContext;
        $this->orderProcessor = $orderProcessor;
        $this->productVariantRepository = $productVariantRepository;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function __invoke(CreateOrder $createOrder): void
    {
        $channel = $this->channelProvider->provide();

        /** @var OrderInterface $order */
        $order = $this->orderFactory->createNew();
        $order->setChannel($channel);
        $order->setCurrencyCode($this->currency->getCurrencyCode());
        $order->setLocaleCode($this->localContext->getLocaleCode());

        foreach ($createOrder->products() as $product) {
            /** @var ProductVariant $productVariant */
            $productVariant = $this->productVariantRepository->findOneBy(
                ['code' => $product->sku]
            );
            if (null !== $productVariant) {
                /** @var OrderItemInterface $orderItem */
                $orderItem = $this->orderItemFactory->createNew();
                $orderItem->setProductName($productVariant->getProduct()->getName());
                $orderItem->setVariantName($productVariant->getName());
                $orderItem->setVariant($productVariant);

                if ($product->qty <= $productVariant->getOnHand()) {
                    $this->orderItemQuantityModifier->modify($orderItem, $productVariant->getOnHand());
                    $order->addItem($orderItem);
                }
            }
        }

        if (!empty($order->getItems()->getValues())) {

            /** @var ShipmentInterface $shipment */
            $shipment = $this->shipmentFactory->createNew();

            /** @var ShippingMethod $methodShipment */
            $methodShipment = $this->shippingMethodRepository->findOneBy(
                ['code' => $createOrder->addressInformation()->shipping_method_code]
            );
            $shipment->setMethod($methodShipment);

            /** @var PaymentInterface $payment */
            $payment = $this->paymentFactory->createNew();

            /** @var PaymentMethodInterface $paymentMethod */
            $paymentMethod = $this->paymentMethodRepository->findOneBy(
                ['code' => $createOrder->addressInformation()->payment_method_code]
            );
            $payment->setCurrencyCode($this->currency->getCurrencyCode());

            $payment->setMethod($paymentMethod);
            $order->addShipment($shipment);
            $order->addPayment($payment);
            $order->setCustomer($this->customerProvider->provide($createOrder->CartId()));
            $this->orderProcessor->process($order);
            $this->cartRepository->add($order);
        }
    }
}
