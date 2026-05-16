<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRate extends ChartWidget
{
    protected ?string $heading = 'Monthly Order Rate';
    //protected string|array|int $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $sellerId = Auth::guard('seller')->user()->id;

        // Get last 12 months order count
        $data = Order::where('seller_id', $sellerId)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_orders', 'month')
            ->toArray();

        // Prepare 12 months data (fill missing months with 0)
        $ordersPerMonth = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $ordersPerMonth[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Orders',
                    'data'            => $ordersPerMonth,
                    'backgroundColor' => '#3b82f6',           // Blue color
                    'borderColor'     => '#1e40af',
                    'borderWidth'     => 2,
                    'tension'         => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';        // You can change to 'line' if you prefer
    }

    // Optional: Change colors based on theme
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
