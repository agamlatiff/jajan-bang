<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class OrderAlertWidget extends Widget
{
  protected static string $view = 'filament.widgets.order-alert-widget';

  protected static ?int $sort = -1; // Always on top

  protected int | string | array $columnSpan = 'full';

  public $lastChecked;

  public function mount()
  {
    $this->lastChecked = now()->toDateTimeString();
  }

  public function checkNewOrders()
  {
    $latestOrder = Transaction::where('payment_status', 'SETTLED')
      ->where('created_at', '>', $this->lastChecked)
      ->where('order_status', 'pending')
      ->latest()
      ->first();

    if ($latestOrder) {
      Notification::make()
        ->title('Pesanan Baru Masuk!')
        ->body("Pesanan #{$latestOrder->code} dari {$latestOrder->name} (Meja {$latestOrder->table_number})")
        ->success()
        ->duration(10000)
        ->actions([
          \Filament\Notifications\Actions\Action::make('view')
            ->label('Lihat Pesanan')
            ->url(route('filament.admin.resources.transactions.index')),
          \Filament\Notifications\Actions\Action::make('kitchen')
            ->label('Dapur')
            ->url(route('kitchen'), shouldOpenInNewTab: true),
        ])
        ->send();

      // Play sound via browser event if possible, or just rely on notification
      $this->dispatch('play-notification-sound');
    }

    $this->lastChecked = now()->toDateTimeString();
  }
}
