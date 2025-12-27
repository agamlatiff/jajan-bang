<?php

namespace App\Filament\Widgets;

use App\Models\Foods;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class ProfitMarginWidget extends BaseWidget
{
  protected static ?string $heading = '💰 Laporan Margin Keuntungan (Estimasi)';

  protected static ?int $sort = 7;

  protected int | string | array $columnSpan = 'full';

  public static function canView(): bool
  {
    return auth()->user()->isAdmin();
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Foods::query()
          ->select(
            'foods.name',
            'foods.cost_price',
            'foods.image',
            DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'),
            DB::raw('COALESCE(SUM(transaction_items.quantity * transaction_items.price), 0) as total_revenue'),
            // Cost calculation based on CURRENT cost_price (Constraint: historical cost not tracked)
            DB::raw('COALESCE(SUM(transaction_items.quantity) * foods.cost_price, 0) as total_cost')
          )
          ->leftJoin('transaction_items', 'foods.id', '=', 'transaction_items.foods_id')
          ->leftJoin('transactions', function ($join) {
            $join->on('transaction_items.transactions_id', '=', 'transactions.id')
              ->where('transactions.payment_status', 'SETTLED');
          })
          ->groupBy('foods.id', 'foods.name', 'foods.cost_price', 'foods.image')
          ->having('total_sold', '>', 0)
          ->orderByDesc('total_revenue')
      )
      ->columns([
        Tables\Columns\ImageColumn::make('image')
          ->circular(),
        Tables\Columns\TextColumn::make('name')
          ->label('Menu')
          ->searchable(),
        Tables\Columns\TextColumn::make('total_sold')
          ->label('Terjual')
          ->numeric(),
        Tables\Columns\TextColumn::make('total_revenue')
          ->label('Omzet')
          ->money('IDR')
          ->sortable(),
        Tables\Columns\TextColumn::make('total_cost')
          ->label('HPP (Estimasi)')
          ->money('IDR')
          ->color('danger'),
        Tables\Columns\TextColumn::make('gross_profit')
          ->label('Profit Kotor')
          ->money('IDR')
          ->state(fn($record) => $record->total_revenue - $record->total_cost)
          ->color('success')
          ->weight('bold'),
        Tables\Columns\TextColumn::make('margin_percent')
          ->label('Margin %')
          ->state(fn($record) => $record->total_revenue > 0 ? round((($record->total_revenue - $record->total_cost) / $record->total_revenue) * 100, 1) . '%' : '0%')
          ->badge()
          ->color(fn($state) => (float)$state > 30 ? 'success' : ((float)$state > 10 ? 'warning' : 'danger')),
      ])
      ->paginated(true)
      ->defaultPaginationPageOption(5);
  }
}
