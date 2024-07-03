<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\order;
use Faker\Core\Number;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number as SupportNumber;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('new Orders', order::query()->where('status', 'new')->count()),
            Stat::make('Order Processing', order::query()->where('status', 'processing')->count()),
            Stat::make('Order shipped', order::query()->where('status', 'shipped')->count()),
            Stat::make('Order Delivered', order::query()->where('status', 'delivered')->count()),
            Stat::make('Order Cancel', order::query()->where('status', 'canceled')->count()),
            Stat::make('Average Price', SupportNumber::currency(Order::query()->avg('grand_total'), 'IDR'))
        ];
    }
}
