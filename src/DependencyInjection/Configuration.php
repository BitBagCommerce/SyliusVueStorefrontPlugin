<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\DependencyInjection;

use BitBag\SyliusVueStorefrontPlugin\Request\Cart\ApplyCouponRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\CreateCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\DeleteCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\DeleteCouponRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetAppliedCouponRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetPaymentMethodsRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\GetShippingMethodsRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\PullCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\SetShippingInformationRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\SyncTotalsRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Cart\UpdateCartRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Order\CreateOrderRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Stock\CheckStockRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\Stock\ListStocksRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\ChangePasswordRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\CreateUserRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\GetOrderHistoryRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\ResetPasswordRequest;
use BitBag\SyliusVueStorefrontPlugin\Request\User\UpdateUserRequest;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ConfigurableItemOptionView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ProductOptionExtensionAttributeView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItem\ProductOptionView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\CartItemView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\PaymentMethodView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\ShippingInformationView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\ShippingMethodsView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\RateView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TaxGrandtotalDetailsView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalSegmentExtensionAttributeView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalSegmentView;
use BitBag\SyliusVueStorefrontPlugin\View\Cart\Totals\TotalsView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\Address\RegionView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\AddressView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\SearchCriteria\FilterGroupView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\SearchCriteria\FilterView;
use BitBag\SyliusVueStorefrontPlugin\View\Common\SearchCriteria\SearchCriteriaView;
use BitBag\SyliusVueStorefrontPlugin\View\GenericSuccessView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductCustomAttributeView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductListView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductPriceExtensionAttributeView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductPriceFormattedView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductPriceInfoView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductPriceView;
use BitBag\SyliusVueStorefrontPlugin\View\Product\ProductView;
use BitBag\SyliusVueStorefrontPlugin\View\Stock\StockView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderExtensionAttributesView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\OrderView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\PaymentView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingAssignmentView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingTotalView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistory\ShippingView;
use BitBag\SyliusVueStorefrontPlugin\View\User\OrderHistoryView;
use BitBag\SyliusVueStorefrontPlugin\View\User\UserProfileView;
use BitBag\SyliusVueStorefrontPlugin\View\ValidationErrorView;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bitbag_sylius_vue_storefront_plugin');

        $rootNode = $treeBuilder->getRootNode();

        $this->buildViewClassesNode($rootNode);
        $this->buildRequestClassesNode($rootNode);

        return $treeBuilder;
    }

    private function buildViewClassesNode(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('view_classes')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('address')->defaultValue(AddressView::class)->end()
            ->scalarNode('cart_item')->defaultValue(CartItemView::class)->end()
            ->scalarNode('configurable_item_option')->defaultValue(ConfigurableItemOptionView::class)->end()
            ->scalarNode('filter')->defaultValue(FilterView::class)->end()
            ->scalarNode('filter_group')->defaultValue(FilterGroupView::class)->end()
            ->scalarNode('generic_success')->defaultValue(GenericSuccessView::class)->end()
            ->scalarNode('order')->defaultValue(OrderView::class)->end()
            ->scalarNode('order_extension_attributes')->defaultValue(OrderExtensionAttributesView::class)->end()
            ->scalarNode('order_history')->defaultValue(OrderHistoryView::class)->end()
            ->scalarNode('payment')->defaultValue(PaymentView::class)->end()
            ->scalarNode('payment_method')->defaultValue(PaymentMethodView::class)->end()
            ->scalarNode('product')->defaultValue(ProductView::class)->end()
            ->scalarNode('product_custom_attribute')->defaultValue(ProductCustomAttributeView::class)->end()
            ->scalarNode('product_list')->defaultValue(ProductListView::class)->end()
            ->scalarNode('product_option')->defaultValue(ProductOptionView::class)->end()
            ->scalarNode('product_option_extension_attribute')->defaultValue(ProductOptionExtensionAttributeView::class)->end()
            ->scalarNode('product_price')->defaultValue(ProductPriceView::class)->end()
            ->scalarNode('product_price_extension_attribute')->defaultValue(ProductPriceExtensionAttributeView::class)->end()
            ->scalarNode('product_price_formatted')->defaultValue(ProductPriceFormattedView::class)->end()
            ->scalarNode('product_price_info')->defaultValue(ProductPriceInfoView::class)->end()
            ->scalarNode('rate_view')->defaultValue(RateView::class)->end()
            ->scalarNode('region')->defaultValue(RegionView::class)->end()
            ->scalarNode('search_criteria')->defaultValue(SearchCriteriaView::class)->end()
            ->scalarNode('shipping')->defaultValue(ShippingView::class)->end()
            ->scalarNode('shipping_assignment')->defaultValue(ShippingAssignmentView::class)->end()
            ->scalarNode('shipping_information')->defaultValue(ShippingInformationView::class)->end()
            ->scalarNode('shipping_methods')->defaultValue(ShippingMethodsView::class)->end()
            ->scalarNode('shipping_total')->defaultValue(ShippingTotalView::class)->end()
            ->scalarNode('stock')->defaultValue(StockView::class)->end()
            ->scalarNode('tax_grandtotal_details')->defaultValue(TaxGrandtotalDetailsView::class)->end()
            ->scalarNode('total_segment')->defaultValue(TotalSegmentView::class)->end()
            ->scalarNode('total_segment_extension_attribute')->defaultValue(TotalSegmentExtensionAttributeView::class)->end()
            ->scalarNode('totals')->defaultValue(TotalsView::class)->end()
            ->scalarNode('user_profile')->defaultValue(UserProfileView::class)->end()
            ->scalarNode('validation_error')->defaultValue(ValidationErrorView::class)->end()
            ->end()
            ->end()
            ->end();
    }

    private function buildRequestClassesNode(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('request_classes')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('apply_coupon')->defaultValue(ApplyCouponRequest::class)->end()
            ->scalarNode('change_password')->defaultValue(ChangePasswordRequest::class)->end()
            ->scalarNode('check_stock')->defaultValue(CheckStockRequest::class)->end()
            ->scalarNode('create_cart')->defaultValue(CreateCartRequest::class)->end()
            ->scalarNode('create_order')->defaultValue(CreateOrderRequest::class)->end()
            ->scalarNode('create_user')->defaultValue(CreateUserRequest::class)->end()
            ->scalarNode('delete_cart')->defaultValue(DeleteCartRequest::class)->end()
            ->scalarNode('delete_coupon')->defaultValue(DeleteCouponRequest::class)->end()
            ->scalarNode('get_applied_coupon')->defaultValue(GetAppliedCouponRequest::class)->end()
            ->scalarNode('get_order_history')->defaultValue(GetOrderHistoryRequest::class)->end()
            ->scalarNode('get_payment_methods')->defaultValue(GetPaymentMethodsRequest::class)->end()
            ->scalarNode('get_shipping_methods')->defaultValue(GetShippingMethodsRequest::class)->end()
            ->scalarNode('list_stocks')->defaultValue(ListStocksRequest::class)->end()
            ->scalarNode('pull_cart')->defaultValue(PullCartRequest::class)->end()
            ->scalarNode('reset_password')->defaultValue(ResetPasswordRequest::class)->end()
            ->scalarNode('set_shipping_information')->defaultValue(SetShippingInformationRequest::class)->end()
            ->scalarNode('sync_totals')->defaultValue(SyncTotalsRequest::class)->end()
            ->scalarNode('update_cart')->defaultValue(UpdateCartRequest::class)->end()
            ->scalarNode('update_user')->defaultValue(UpdateUserRequest::class)->end()
            ->end()
            ->end()
            ->end();
    }
}
