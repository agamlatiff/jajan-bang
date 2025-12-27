<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #D91E26; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        .summary { background: #f5f5f5; padding: 10px; margin-bottom: 20px; }
        .summary-item { display: inline-block; margin-right: 30px; }
        .summary-label { color: #666; }
        .summary-value { font-size: 18px; font-weight: bold; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #D91E26; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .total { text-align: right; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍽️ JajanBang</h1>
        <p>Laporan Transaksi</p>
        <p>Periode: {{ $from }} s/d {{ $until }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ $totalOrders }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Pendapatan</div>
            <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Customer</th>
                <th>Meja</th>
                <th>Status</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->code }}</td>
                <td>{{ $t->name }}</td>
                <td>{{ $t->table_number ?? '-' }}</td>
                <td>{{ $t->order_status?->value ?? '-' }}</td>
                <td class="total">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }} | JajanBang Admin
    </div>
</body>
</html>
