<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class CustomerInsightsWidget extends BaseWidget
{
  protected static ?string $heading = '🏆 Top Pelanggan';

  protected static ?int $sort = 6;

  protected int | string | array $columnSpan = 'half';

  public static function canView(): bool
  {
    return auth()->user()->isAdmin();
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Transaction::query()
          ->select(
            'name',
            'phone',
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total_price) as total_spent')
          )
          ->where('payment_status', 'SETTLED')
          ->groupBy('name', 'phone')
          ->orderByDesc('total_spent')
          ->limit(5)
      )
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->label('Nama')
          ->weight('bold')
          ->searchable(),
        Tables\Columns\TextColumn::make('total_orders')
          ->label('Order')
          ->alignCenter()
          ->badge()
          ->color('info'),
        Tables\Columns\TextColumn::make('total_spent')
          ->label('Total Belanja')
          ->money('IDR')
          ->color('success')
          ->sortable(),
      ])
      ->paginated(false);
  }
}
