<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan (Detail)</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #EEE;
        }
    </style>
</head>

<body>
    <div>
        <h1>PT JAYA ABADI</h1>
        <span style="display: block; margin-bottom: 4px;">Laporan Penjualan Detail</span>
        <span style="display: block; margin-bottom: 4px;">
            Periode: {{ $formattedStartDate }} s.d {{ $formattedEndDate }}
        </span>
        <span style="display: block; margin-bottom: 4px;">Kategori: BARANG IMPORT</span>
    </div>

    @forelse ($reportData as $index => $report)
        <div style="margin-top: 20px;">
            <div>
                <span style="display: block; padding-bottom: 5px;">Nomor Invoice: {{ $report['invoice'] }}</span>
                <span style="display: block; padding-bottom: 5px;">
                    Pelanggan: {{ $report['customer']['customerName'] }} ({{ $report['customer']['customerCategory'] }})
                </span>
                <span style="display: block;;">
                    Tanggal Transaksi: {{ $report['date'] }} WIB
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th style="width: 50px;">Kode Barang</th>
                        <th style="width: 100px">Nama Barang</th>
                        <th style="width: 70px;">Harga (JUAL)</th>
                        <th style="width: 70px;">Jumlah (PCS)</th>
                        <th style="width: 70px;">Jumlah (JUAL)</th>
                        <th style="width: 70px;">Jumlah (POKOK)</th>
                        <th style="width: 70px;">LABA/RUGI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report['stocks'] as $i => $stock)
                        @php
                            $quantity = 0;
                            $lr = 0;
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $stock['stockCode'] }}</td>
                            <td>{{ $stock['stockName'] }}</td>
                            <td>{{ number_format($stock['price']) }}</td>
                            <td>{{ $stock['quantity'] }}</td>
                            <td>{{ number_format($stock['total']) }}</td>
                            <td>{{ number_format($stock['hppPrice']) }}</td>
                            <td>{{ number_format($stock['lr']) }}</td>
                        </tr>
                        @php
                            $quantity += $stock['quantity'];
                            $lr += $stock['lr'];
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align: right; border: 0;">Diskon</td>
                        <td style="border: 0;"></td>
                        <td style="border: 0; color:red">{{ number_format($report['subtotalDiscount']) }}</td>
                        <td style="border: 0;"></td>
                        <td style="border: 0;"></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; border: 0;">Hutang</td>
                        <td style="border: 0;"></td>
                        <td style="border: 0; color:red">{{ number_format($report['subtotalCredit']) }}</td>
                        <td style="border: 0;"></td>
                        <td style="border: 0;"></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; border: 0;">Subtotal</td>
                        <td style="border: 0;">{{ $quantity }}</td>
                        <td style="border: 0;">
                            {{ number_format($report['subtotalPrice'] - $report['subtotalDiscount']) }}
                        </td>
                        <td style="border: 0;">{{ number_format($report['subtotalHppPrice']) }}</td>
                        <td style="border: 0;">
                            {{ number_format($report['subtotalPrice'] - $report['subtotalDiscount'] - $report['subtotalHppPrice']) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
    @endforelse
</body>

</html>
