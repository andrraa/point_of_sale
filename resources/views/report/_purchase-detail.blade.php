<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembelian (Detail)</title>

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
    {{-- <div>
        <h1>PT JAYA ABADI</h1>
        <span style="display: block; margin-bottom: 4px;">Laporan Penjualan Detail</span>
        <span style="display: block; margin-bottom: 4px;">
            Periode: {{ $formattedStartDate }} s.d {{ $formattedEndDate }}
        </span>
        <span style="display: block; margin-bottom: 4px;">Kategori: BARANG IMPORT</span>
    </div> --}}

    @php
        $grandTotalQty = 0;
        $grandTotalPrice = 0;
    @endphp

    @forelse ($reportData as $index => $report)
        <div style="margin-top: 20px;">
            <div>
                <span style="display: block; padding-bottom: 5px;">Nomor Invoice: {{ $report['invoice'] }}</span>
                <span style="display: block; padding-bottom: 5px;">
                    Pemasok: {{ $report['supplier']['supplierName'] }}
                </span>
                <span style="display: block;">
                    Tanggal Transaksi: {{ $report['date'] }} WIB
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th style="width: 50px;">Kode Barang</th>
                        <th style="width: 100px;">Nama Barang</th>
                        <th style="width: 70px;">Harga (BELI)</th>
                        <th style="width: 70px;">Jumlah (PCS)</th>
                        <th style="width: 70px;">Total (HARGA)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalQuantity = 0;
                        $totalPrice = 0;
                    @endphp

                    @foreach ($report['stocks'] as $i => $stock)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $stock['stockCode'] }}</td>
                            <td>{{ $stock['stockName'] }}</td>
                            <td>{{ number_format($stock['price']) }}</td>
                            <td>{{ $stock['quantity'] }}</td>
                            <td>{{ number_format($stock['total']) }}</td>
                        </tr>
                        @php
                            $totalQuantity += $stock['quantity'];
                            $totalPrice += $stock['total'];
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="4" style="text-align: center;"><em>Subtotal</em></td>
                        <td><strong>{{ $totalQuantity }}</strong></td>
                        <td><strong>{{ number_format($totalPrice) }}</strong></td>
                    </tr>

                    @php
                        $grandTotalQty += $totalQuantity;
                        $grandTotalPrice += $totalPrice;
                    @endphp
                </tbody>
            </table>
        </div>
    @empty
    @endforelse

    @if (count($reportData))
        <div style="margin-top: 30px; border-top: 2px solid #000; padding-top: 10px;">
            <h4>Total Keseluruhan:</h4>
            <table>
                <tr>
                    <td style="width: 200px;">Total Jumlah (PCS):</td>
                    <td><strong>{{ $grandTotalQty }}</strong></td>
                </tr>
                <tr>
                    <td>Total Pembelian (Rp):</td>
                    <td><strong>{{ number_format($grandTotalPrice) }}</strong></td>
                </tr>
            </table>
        </div>
    @endif

</body>

</html>
