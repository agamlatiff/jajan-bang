<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class HourlySalesChartWidget extends ChartWidget
{
  protected static ?string $heading = '🔥 Jam Sibuk (Penjualan per Jam)';

  protected static ?int $sort = 5;

  protected int | string | array $columnSpan = 'half';

  public static function canView(): bool
  {
    return auth()->user()->isAdmin();
  }

  protected function getData(): array
  {
    // Get data for the last 30 days to get a good average, or just all time?
    // Let's do average daily distribution or just total sum per hour for the last 30 days.

    $data = Transaction::where('created_at', '>=', now()->subDays(30))
      ->where('payment_status', 'SETTLED')
      ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
      ->groupBy('hour')
      ->orderBy('hour')
      ->pluck('count', 'hour')
      ->toArray();

    // Fill missing hours with 0
    $chartData = [];
    for ($i = 0; $i < 24; $i++) {
      $chartData[] = $data[$i] ?? 0;
    }

    return [
      'datasets' => [
        [
          'label' => 'Jumlah Transaksi',
          'data' => $chartData,
          'backgroundColor' => 'rgba(217, 30, 38, 0.5)',
          'borderColor' => 'rgb(217, 30, 38)',
        ],
      ],
      'labels' => array_map(fn($h) => sprintf('%02d:00', $h), range(0, 23)),
    ];
  }

  protected function getType(): string
  {
    return 'bar';
  }
}
