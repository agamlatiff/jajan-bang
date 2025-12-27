<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Best Sellers</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #D91E26; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #D91E26; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .rank { font-weight: bold; color: #D91E26; }
        .total { text-align: right; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔥 JajanBang - Menu Terlaris</h1>
        <p>Laporan per {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Menu</th>
                <th>Harga</th>
                <th>Terjual</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bestSellers as $index => $item)
            <tr>
                <td class="rank">{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->total_sold }} pcs</td>
                <td class="total">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }} | JajanBang Admin
    </div>
</body>
</html>
