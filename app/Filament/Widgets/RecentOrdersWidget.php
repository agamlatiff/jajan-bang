<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
  protected static ?int $sort = 2;

  protected int | string | array $columnSpan = 'full';

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Transaction::query()
          ->where('payment_status', 'SETTLED')
          ->latest()
          ->limit(10)
      )
      ->columns([
        Tables\Columns\TextColumn::make('code')
          ->label('Invoice')
          ->searchable()
          ->badge()
          ->color('primary'),

        Tables\Columns\TextColumn::make('name')
          ->label('Customer')
          ->searchable(),

        Tables\Columns\TextColumn::make('total')
          ->label('Total')
          ->money('IDR')
          ->sortable(),

        Tables\Columns\TextColumn::make('payment_method')
          ->label('Metode')
          ->badge()
          ->color('success'),

        Tables\Columns\TextColumn::make('order_status')
          ->label('Status')
          ->badge()
          ->formatStateUsing(fn($state) => $state?->label() ?? 'Pending')
          ->color(fn($state) => match ($state?->value ?? 'pending') {
            'pending' => 'warning',
            'confirmed' => 'info',
            'preparing' => 'warning',
            'ready' => 'success',
            'delivered' => 'gray',
            'cancelled' => 'danger',
            default => 'gray',
          }),

        Tables\Columns\TextColumn::make('created_at')
          ->label('Waktu')
          ->dateTime('d M Y, H:i')
          ->sortable(),
      ])
      ->defaultSort('created_at', 'desc')
      ->heading('Pesanan Terbaru')
      ->paginated(false);
  }
}
