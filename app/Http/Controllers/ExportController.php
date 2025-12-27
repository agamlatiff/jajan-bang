<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Foods;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
  /**
   * Export transactions to PDF
   */
  public function transactionsPdf(Request $request)
  {
    $from = $request->get('from', now()->startOfMonth()->toDateString());
    $until = $request->get('until', now()->toDateString());

    $transactions = Transaction::with('items.food')
      ->where('payment_status', 'SETTLED')
      ->whereBetween('created_at', [$from, $until . ' 23:59:59'])
      ->orderBy('created_at', 'desc')
      ->get();

    $totalRevenue = $transactions->sum('total_price');
    $totalOrders = $transactions->count();

    $pdf = Pdf::loadView('exports.transactions', [
      'transactions' => $transactions,
      'from' => $from,
      'until' => $until,
      'totalRevenue' => $totalRevenue,
      'totalOrders' => $totalOrders,
    ]);

    return $pdf->download('laporan-transaksi-' . $from . '-' . $until . '.pdf');
  }

  /**
   * Export best sellers to PDF
   */
  public function bestSellersPdf(Request $request)
  {
    $bestSellers = Foods::query()
      ->select(
        'foods.name',
        'foods.price',
        DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total_sold'),
        DB::raw('COALESCE(SUM(transaction_items.quantity * transaction_items.price), 0) as total_revenue')
      )
      ->leftJoin('transaction_items', 'foods.id', '=', 'transaction_items.foods_id')
      ->leftJoin('transactions', function ($join) {
        $join->on('transaction_items.transactions_id', '=', 'transactions.id')
          ->where('transactions.payment_status', 'SETTLED');
      })
      ->groupBy('foods.id', 'foods.name', 'foods.price')
      ->orderByDesc('total_sold')
      ->limit(20)
      ->get();

    $pdf = Pdf::loadView('exports.best-sellers', [
      'bestSellers' => $bestSellers,
      'date' => now()->format('d M Y'),
    ]);

    return $pdf->download('laporan-best-sellers-' . now()->format('Y-m-d') . '.pdf');
  }

  /**
   * Export transactions to CSV (already implemented in bulk action, this is standalone)
   */
  public function transactionsCsv(Request $request)
  {
    $from = $request->get('from', now()->startOfMonth()->toDateString());
    $until = $request->get('until', now()->toDateString());

    $transactions = Transaction::where('payment_status', 'SETTLED')
      ->whereBetween('created_at', [$from, $until . ' 23:59:59'])
      ->orderBy('created_at', 'desc')
      ->get();

    return response()->streamDownload(function () use ($transactions) {
      echo "Kode,Nama,Telepon,Meja,Metode,Total,Status Order,Tanggal\n";

      foreach ($transactions as $t) {
        echo sprintf(
          "%s,\"%s\",%s,%s,%s,%s,%s,%s\n",
          $t->code,
          str_replace('"', '""', $t->name),
          $t->phone,
          $t->table_number ?? '-',
          $t->payment_method,
          $t->total_price,
          $t->order_status?->value ?? '-',
          $t->created_at->format('Y-m-d H:i:s')
        );
      }
    }, 'transaksi-' . $from . '-' . $until . '.csv');
  }
}
