<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
  protected static ?string $heading = '📈 Pendapatan 7 Hari Terakhir';

  protected static ?int $sort = 4;

  protected int | string | array $columnSpan = 'full';

  protected function getData(): array
  {
    $data = collect(range(6, 0))->map(function ($daysAgo) {
      $date = Carbon::today()->subDays($daysAgo);

      $revenue = Transaction::whereDate('created_at', $date)
        ->where('payment_status', 'SETTLED')
        ->sum('total_price');

      return [
        'date' => $date->format('d M'),
        'revenue' => $revenue,
      ];
    });

    return [
      'datasets' => [
        [
          'label' => 'Pendapatan (Rp)',
          'data' => $data->pluck('revenue')->toArray(),
          'fill' => true,
          'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
          'borderColor' => 'rgb(249, 115, 22)',
          'tension' => 0.3,
        ],
      ],
      'labels' => $data->pluck('date')->toArray(),
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }

  protected function getOptions(): array
  {
    return [
      'plugins' => [
        'legend' => [
          'display' => false,
        ],
      ],
      'scales' => [
        'y' => [
          'beginAtZero' => true,
          'ticks' => [
            'callback' => "function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }",
          ],
        ],
      ],
    ];
  }
}
