<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Distributor Report — {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</title>
    <link rel="stylesheet" href="{{ asset('css/madura-mart.css') }}">
</head>
<body class="print-report-body--segoe" onload="window.print()">
    <h1>📦 Distributor Procurement Report</h1>
    <p class="print-meta">
        <strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}<br>
        <strong>Generated:</strong> {{ now()->format('d M Y H:i') }}
    </p>

    <table class="print-table">
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
            <tr class="print-total-row">
                <td colspan="4" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalPurchaseValue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
