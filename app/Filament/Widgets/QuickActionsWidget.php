<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\FoodsResource;
use App\Filament\Resources\TransactionResource;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
  protected static string $view = 'filament.widgets.quick-actions-widget';

  protected static ?int $sort = 0;

  protected int | string | array $columnSpan = 'full';

  public function getActions(): array
  {
    return [
      [
        'label' => 'Tambah Menu Baru',
        'icon' => 'heroicon-o-plus-circle',
        'url' => FoodsResource::getUrl('create'),
        'color' => 'primary',
        'description' => 'Tambah item menu baru',
      ],
      [
        'label' => 'Lihat Semua Pesanan',
        'icon' => 'heroicon-o-clipboard-document-list',
        'url' => TransactionResource::getUrl('index'),
        'color' => 'info',
        'description' => 'Kelola semua transaksi',
      ],
      [
        'label' => 'Dashboard Dapur',
        'icon' => 'heroicon-o-fire',
        'url' => route('kitchen'),
        'color' => 'warning',
        'description' => 'Buka tampilan dapur',
        'external' => true,
      ],
    ];
  }
}
