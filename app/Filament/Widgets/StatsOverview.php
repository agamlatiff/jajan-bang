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
    $thisMonth = now()->startOfMonth();

    // Today's stats
    $todayRevenue = Transaction::whereDate('created_at', $today)
      ->where('payment_status', 'SETTLED')
      ->sum('total');

    $todayOrders = Transaction::whereDate('created_at', $today)
      ->where('payment_status', 'SETTLED')
      ->count();

    // This month stats
    $monthRevenue = Transaction::where('created_at', '>=', $thisMonth)
      ->where('payment_status', 'SETTLED')
      ->sum('total');

    $monthOrders = Transaction::where('created_at', '>=', $thisMonth)
      ->where('payment_status', 'SETTLED')
      ->count();

    // Pending orders
    $pendingOrders = Transaction::where('payment_status', 'PENDING')->count();

    // Total menu items
    $totalMenuItems = Foods::count();

    return [
      Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
        ->description($todayOrders . ' pesanan')
        ->descriptionIcon('heroicon-m-shopping-bag')
        ->color('success')
        ->chart([7, 3, 4, 5, 6, $todayOrders]),

      Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthRevenue, 0, ',', '.'))
        ->description($monthOrders . ' total pesanan')
        ->descriptionIcon('heroicon-m-calendar')
        ->color('primary'),

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
