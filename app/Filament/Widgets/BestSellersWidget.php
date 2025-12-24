<?php

namespace App\Filament\Widgets;

use App\Models\Foods;
use App\Models\TransactionItems;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class BestSellersWidget extends BaseWidget
{
  protected static ?int $sort = 3;

  protected int | string | array $columnSpan = 'full';

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Foods::query()
          ->select('foods.*', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'))
          ->leftJoin('transaction_items', 'foods.id', '=', 'transaction_items.foods_id')
          ->groupBy('foods.id')
          ->orderByDesc('total_sold')
          ->limit(5)
      )
      ->columns([
        Tables\Columns\ImageColumn::make('image')
          ->label('')
          ->circular()
          ->size(40)
          ->getStateUsing(function ($record) {
            return str_starts_with($record->image, 'http')
              ? $record->image
              : asset('storage/' . $record->image);
          }),

        Tables\Columns\TextColumn::make('name')
          ->label('Menu')
          ->searchable()
          ->weight('bold'),

        Tables\Columns\TextColumn::make('price')
          ->label('Harga')
          ->money('IDR'),

        Tables\Columns\TextColumn::make('total_sold')
          ->label('Terjual')
          ->badge()
          ->color('success')
          ->suffix(' pcs'),

        Tables\Columns\IconColumn::make('is_promo')
          ->label('Promo')
          ->boolean(),
      ])
      ->heading('🔥 Menu Terlaris')
      ->paginated(false);
  }
}
