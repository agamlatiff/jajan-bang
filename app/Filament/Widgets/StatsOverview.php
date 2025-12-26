<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Foods;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected function getStats(): array
  {
    $today = now()->startOfDay();
    $yesterday = now()->subDay()->startOfDay();
    $thisMonth = now()->startOfMonth();
    $lastMonth = now()->subMonth()->startOfMonth();

    // Today's stats
    $todayRevenue = Transaction::whereDate('created_at', $today)
      ->where('payment_status', 'SETTLED')
      ->sum('total_price');

    $todayOrders = Transaction::whereDate('created_at', $today)
      ->where('payment_status', 'SETTLED')
      ->count();

    // Yesterday's stats for comparison
    $yesterdayRevenue = Transaction::whereDate('created_at', $yesterday)
      ->where('payment_status', 'SETTLED')
      ->sum('total_price');

    // Calculate trend
    $revenueTrend = $yesterdayRevenue > 0
      ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1)
      : ($todayRevenue > 0 ? 100 : 0);

    // This month stats
    $monthRevenue = Transaction::where('created_at', '>=', $thisMonth)
      ->where('payment_status', 'SETTLED')
      ->sum('total_price');

    $monthOrders = Transaction::where('created_at', '>=', $thisMonth)
      ->where('payment_status', 'SETTLED')
      ->count();

    // Last month for comparison
    $lastMonthRevenue = Transaction::whereBetween('created_at', [$lastMonth, $thisMonth])
      ->where('payment_status', 'SETTLED')
      ->sum('total_price');

    $monthTrend = $lastMonthRevenue > 0
      ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
      : ($monthRevenue > 0 ? 100 : 0);

    // Pending orders
    $pendingOrders = Transaction::where('payment_status', 'PENDING')->count();

    // Total menu items
    $totalMenuItems = Foods::count();

    return [
      Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
        ->description($revenueTrend >= 0 ? '+' . $revenueTrend . '% dari kemarin' : $revenueTrend . '% dari kemarin')
        ->descriptionIcon($revenueTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($revenueTrend >= 0 ? 'success' : 'danger')
        ->chart([7, 3, 4, 5, 6, $todayOrders]),

      Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
        ->description($monthTrend >= 0 ? '+' . $monthTrend . '% dari bulan lalu' : $monthTrend . '% dari bulan lalu')
        ->descriptionIcon($monthTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($monthTrend >= 0 ? 'primary' : 'warning'),

      Stat::make('Pesanan Pending', $pendingOrders)
        ->description('Menunggu pembayaran')
        ->descriptionIcon('heroicon-m-clock')
        ->color($pendingOrders > 0 ? 'warning' : 'gray'),

      Stat::make('Total Menu', $totalMenuItems)
        ->description('Item aktif')
        ->descriptionIcon('heroicon-m-squares-2x2')
        ->color('info'),
    ];
  }
}
