<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $products = Product::where('seller_id', Auth::guard('seller')->user()->id)->count();
        $orders = Order::where('seller_id', Auth::guard('seller')->user()->id)->count();
        return [
            Stat::make('Total Products', $products),
            Stat::make('Orders', $orders),
        ];
    }
}
