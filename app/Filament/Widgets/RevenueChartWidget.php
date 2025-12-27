<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
  protected static ?string $heading = '📈 Trend Pendapatan';

  protected static ?int $sort = 3;

  public ?string $filter = 'week';

  protected function getFilters(): ?array
  {
    return [
      'today' => 'Hari Ini',
      'week' => 'Minggu Ini',
      'month' => 'Bulan Ini',
      'year' => 'Tahun Ini',
    ];
  }

  protected function getData(): array
  {
    $activeFilter = $this->filter;

    $query = Transaction::query()->where('payment_status', 'SETTLED');

    $data = [];
    $labels = [];

    switch ($activeFilter) {
      case 'today':
        // Hourly data for today
        $data = collect(range(0, 23))->map(function ($hour) use ($query) {
          $start = Carbon::today()->addHours($hour);
          $end = Carbon::today()->addHours($hour + 1);

          return $query->clone()
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_price');
        });
        $labels = collect(range(0, 23))->map(fn($h) => sprintf('%02d:00', $h));
        break;

      case 'week':
        // Daily data for last 7 days
        $data = collect(range(6, 0))->map(function ($daysAgo) use ($query) {
          $date = Carbon::today()->subDays($daysAgo);
          return $query->clone()
            ->whereDate('created_at', $date)
            ->sum('total_price');
        });
        $labels = collect(range(6, 0))->map(fn($d) => Carbon::today()->subDays($d)->format('d M'));
        break;

      case 'month':
        // Daily data for this month
        $daysInMonth = Carbon::now()->daysInMonth;
        $data = collect(range(1, $daysInMonth))->map(function ($day) use ($query) {
          $date = Carbon::now()->startOfMonth()->addDays($day - 1);
          // Only up to today
          if ($date->isFuture()) return 0;

          return $query->clone()
            ->whereDate('created_at', $date)
            ->sum('total_price');
        });
        $labels = collect(range(1, $daysInMonth))->map(fn($d) => $d);
        break;

      case 'year':
        // Monthly data for this year
        $data = collect(range(1, 12))->map(function ($month) use ($query) {
          return $query->clone()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $month)
            ->sum('total_price');
        });
        $labels = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'));
        break;
    }

    return [
      'datasets' => [
        [
          'label' => 'Pendapatan (Rp)',
          'data' => $data->toArray(),
          'fill' => true,
          'backgroundColor' => 'rgba(217, 30, 38, 0.1)', // JajanBang Red transparent
          'borderColor' => 'rgb(217, 30, 38)', // JajanBang Red
          'tension' => 0.3,
        ],
      ],
      'labels' => $labels->toArray(),
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
