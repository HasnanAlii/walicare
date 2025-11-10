<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyaluran Donasi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .subtotal { background-color: #e8f5e9; font-weight: bold; }
        .grand-total { background-color: #c8e6c9; font-weight: bold; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">LAPORAN PENYALURAN DONASI BULAN {{ now()->format('F Y') }}</h3>

    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Laporan Penyaluran Donasi</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($programUses as $use)
                <tr>
                    <td>{{ $use->program->title ?? '-' }}</td>
                    <td>{{ $use->note ?? '-' }}</td>
                    <td>{{ $use->program->location ?? '-' }}</td>
                    <td class="text-right">{{ number_format($use->amount, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $use->tanggal ? $use->tanggal->format('d/m/Y') : '-' }}</td>
                </tr>
                @php $total += $use->amount; @endphp
            @endforeach
            <tr class="grand-total">
                <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
