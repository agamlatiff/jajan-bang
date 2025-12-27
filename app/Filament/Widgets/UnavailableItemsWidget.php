<?php

namespace App\Filament\Widgets;

use App\Models\Foods;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UnavailableItemsWidget extends BaseWidget
{
  protected static ?string $heading = '⚠️ Menu Tidak Tersedia (Out of Stock)';

  protected static ?int $sort = 8;

  protected int | string | array $columnSpan = 'half';

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Foods::query()->where('is_available', false)
      )
      ->columns([
        Tables\Columns\ImageColumn::make('image')
          ->circular(),
        Tables\Columns\TextColumn::make('name')
          ->label('Menu')
          ->weight('bold'),
        Tables\Columns\ToggleColumn::make('is_available')
          ->label('Tersedia?')
          ->afterStateUpdated(function () {
            // Refresh widget if needed
          }),
      ])
      ->paginated(false);
  }
}
