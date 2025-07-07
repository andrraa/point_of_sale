<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Stok</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px dotted #000;
            padding: 4px;
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background-color: #EEE;
        }
    </style>

</head>

<body>
    @php
        $grandTotalQty = 0;
        $grandTotalOut = 0;
        $grandTotalPrice = 0;
    @endphp

    <h2>Laporan Stok</h2>

    @forelse ($stocks as $category => $stock)
        <div style="margin-top: 20px;">
            <h3>Kategori:
                {{ optional($stock->first()->category)->category_name ?? 'Tidak diketahui' }}
            </h3>

            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 10px;">No.</th>
                        <th style="width: 300px;">Barang</th>
                        <th style="width: 70px;">Stok Total</th>
                        <th style="width: 70px;">Stok Keluar</th>
                        <th style="width: 70px;">Harga Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalQuantity = 0;
                        $totalOut = 0;
                        $totalPrice = 0;
                    @endphp

                    @foreach ($stock as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ "$item->stock_code - $item->stock_name" }}</td>
                            <td>{{ $item->stock_total }} pcs</td>
                            <td>{{ $item->stock_out }} pcs</td>
                            <td>Rp {{ number_format($item->stock_purchase_price) }}</td>
                        </tr>
                        @php
                            $totalQuantity += $item->stock_total;
                            $totalOut += $item->stock_out;
                            $totalPrice += $item->stock_purchase_price * $item->stock_out;
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="2" style="text-align: center;"><em>Subtotal</em></td>
                        <td><strong>{{ $totalQuantity }} pcs</strong></td>
                        <td><strong>{{ $totalOut }} pcs</strong></td>
                        <td><strong>Rp {{ number_format($totalPrice) }}</strong></td>
                    </tr>
                </tbody>
            </table>

            @php
                $grandTotalQty += $totalQuantity;
                $grandTotalOut += $totalOut;
                $grandTotalPrice += $totalPrice;
            @endphp
        </div>
    @empty
        <p>Tidak ada data laporan.</p>
    @endforelse

    @if ($grandTotalQty !== 0 || $grandTotalPrice !== 0)
        <table style="margin-top: 30px; width: 80%%;">
            <thead>
                <tr>
                    <th style="text-align: left; width: 250px;">Total Keseluruhan</th>
                    <th style="text-align: right; width: 150px;">Stok Total</th>
                    <th style="text-align: right; width: 150px;">Stok Keluar</th>
                    <th style="text-align: right; width: 200px;">Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Grand Total</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalQty }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalOut }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">
                        Rp {{ number_format($grandTotalPrice) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

</body>

</html>
