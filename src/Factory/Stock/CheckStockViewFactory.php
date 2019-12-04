<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Factory\Stock;

use BitBag\SyliusVueStorefrontPlugin\View\Stock\StockView;

final class CheckStockViewFactory implements CheckStockViewFactoryInterface
{
    public function create(): StockView
    {
        $stockView = new StockView();
        $stockView->item_id = 580; // z syliusa
        $stockView->product_id = 500; // z syliusa
        $stockView->stock_id = 1;
        $stockView->qty = 53; // z syliusa
        $stockView->is_in_stock = true;
        $stockView->is_qty_decimal = false;
        $stockView->show_default_notification_message = false;
        $stockView->use_config_max_sale_qty = true;
        $stockView->min_sale_qty = 10000;
        $stockView->use_config_backorders = true;
        $stockView->backorders = 0;
        $stockView->use_config_notify_stock_qty = true;
        $stockView->notify_stock_qty = 1;
        $stockView->use_config_qty_increments = true;
        $stockView->qty_increments = 0;
        $stockView->use_config_enable_qty_inc= true;
        $stockView->enable_qty_increments = false;
        $stockView->use_config_manage_stock = true;
        $stockView->manage_stock = true;
        $stockView->low_stock_date = null;
        $stockView->is_decimal_divided = false;
        $stockView->stock_status_changed_auto = 0;

        return $stockView;
    }
}