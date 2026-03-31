<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Distributor Report — {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .meta { color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: 600; text-transform: uppercase; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { background-color: #f0f0f0; font-weight: bold; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body onload="window.print()">
    <h1>📦 Distributor Procurement Report</h1>
    <p class="meta">
        <strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}<br>
        <strong>Generated:</strong> {{ now()->format('d M Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Distributor</th>
                <th>Phone</th>
                <th class="text-center">Purchases</th>
                <th class="text-right">Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributors->sortByDesc('purchases_sum_total_price') as $index => $dist)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dist->name }}</td>
                    <td>{{ $dist->phone_number }}</td>
                    <td class="text-center">{{ $dist->purchases_count }}</td>
                    <td class="text-right">Rp {{ number_format($dist->purchases_sum_total_price ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalPurchaseValue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
