<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use App\Filament\Resources\OrderResource;
use App\Models\order as ModelsOrder;
use Stripe\Climate\Order;

class reportChart extends ChartWidget
{
    protected static ?string $heading = 'Income';

    protected function getData(): array
    {
        $data = Trend::model(ModelsOrder::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->sum('grand_total');

    return [
        'datasets' => [
            [
                'label' => 'Order',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
