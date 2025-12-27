<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Page implements HasTable
{
  use InteractsWithTable;

  protected static ?string $navigationIcon = 'heroicon-o-clock';

  protected static string $view = 'filament.pages.activity-log';

  protected static ?string $navigationLabel = 'Activity Log';

  protected static ?string $title = '📋 Activity Log';

  protected static ?string $navigationGroup = 'Keamanan';

  protected static ?int $navigationSort = 99;

  public static function canAccess(): bool
  {
    return auth()->user()->isAdmin();
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(Activity::query()->latest())
      ->columns([
        TextColumn::make('created_at')
          ->label('Waktu')
          ->dateTime('d M Y, H:i')
          ->sortable(),
        TextColumn::make('causer.name')
          ->label('User')
          ->default('-')
          ->badge()
          ->color('info'),
        TextColumn::make('description')
          ->label('Aksi')
          ->wrap(),
        TextColumn::make('subject_type')
          ->label('Model')
          ->formatStateUsing(fn($state) => class_basename($state))
          ->badge()
          ->color('gray'),
        TextColumn::make('subject_id')
          ->label('ID'),
        TextColumn::make('properties')
          ->label('Perubahan')
          ->formatStateUsing(function ($state) {
            if (!$state) return '-';
            $data = $state->toArray();
            $output = [];
            if (isset($data['old'])) {
              foreach ($data['old'] as $key => $value) {
                $new = $data['attributes'][$key] ?? '-';
                $output[] = "{$key}: {$value} → {$new}";
              }
            } elseif (isset($data['attributes'])) {
              foreach ($data['attributes'] as $key => $value) {
                $output[] = "{$key}: {$value}";
              }
            }
            return implode(', ', $output) ?: '-';
          })
          ->wrap()
          ->limit(50),
      ])
      ->filters([
        SelectFilter::make('subject_type')
          ->label('Model')
          ->options([
            \App\Models\Transaction::class => 'Transaction',
            \App\Models\Foods::class => 'Foods',
          ]),
      ])
      ->defaultSort('created_at', 'desc')
      ->paginated([10, 25, 50]);
  }
}
