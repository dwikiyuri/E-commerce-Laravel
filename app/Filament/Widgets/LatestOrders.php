<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                ->label('Order ID')
                ->searchable(),

                TextColumn::make('user.name')
                ->searchable(),

                TextColumn::make('grand_total')
                ->money('IDR'),

                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string=> match ($state){
                    'new' => 'info',
                    'processing' => 'warning',
                    'shipped' => 'success',
                    'delivered' => 'success',
                    'canceled' => 'danger',
                })
                ->icon(fn (string $state): string=> match ($state){
                    'new' => 'heroicon-o-clock',
                    'processing' => 'heroicon-m-arrow-path',
                    'shipped' => 'heroicon-o-truck',
                    'delivered' => 'heroicon-o-check-circle',
                    'canceled' => 'heroicon-o-x-circle',
                })->sortable(),
                TextColumn::make('payment_method')
                ->sortable()
                ->searchable(),

                TextColumn::make('payment_status')
                ->sortable()
                ->badge()
                ->searchable(),

                TextColumn::make('created_at')
                ->label('Order Date')
                ->dateTime(),
            ])
            ->actions([
                Action::make('View Order')
                ->url(fn (order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                ->icon('heroicon-m-eye')
            ])
            ;
    }
}
