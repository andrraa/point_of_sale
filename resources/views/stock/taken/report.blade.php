<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pengambilan Stok</title>

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
        $grandTotalPrice = 0;
    @endphp

    <h2>Laporan Tanggal {{ $startDate }} s.d {{ $endDate }}</h2>

    @forelse ($data as $categoryId => $takens)
        <div style="margin-top: 20px;">
            <h3>Kategori: {{ optional($takens->first()->category)->category_name ?? 'Tidak diketahui' }}</h3>

            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 10px;">No.</th>
                        <th style="width: 300px;">Barang</th>
                        <th style="width: 70px;">Jumlah</th>
                        <th style="width: 70px;">Harga</th>
                        <th style="width: 100px;">Tanggal</th>
                        <th style="width: 70px;">Pengguna</th>
                        <th style="width: 100px;">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalQuantity = 0;
                        $totalPrice = 0;
                    @endphp

                    @foreach ($takens as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ "$item->stock_taken_stock_code - $item->stock_taken_stock_name" }}</td>
                            <td>{{ $item->stock_taken_quantity }} pcs</td>
                            <td>Rp {{ number_format($item->stock_taken_price) }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ $item->stock_taken_description ?? '' }}</td>
                        </tr>
                        @php
                            $totalQuantity += $item->stock_taken_quantity;
                            $totalPrice += $item->stock_taken_price * $item->stock_taken_quantity;
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="2" style="text-align: center;"><em>Subtotal</em></td>
                        <td><strong>{{ $totalQuantity }} pcs</strong></td>
                        <td><strong>Rp{{ number_format($totalPrice) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>

            @php
                $grandTotalQty += $totalQuantity;
                $grandTotalPrice += $totalPrice;
            @endphp
        </div>
    @empty
        <p>Tidak ada data laporan.</p>
    @endforelse

    @if ($grandTotalQty > 0)
        <table style="margin-top: 30px; width: 50%;">
            <thead>
                <tr>
                    <th style="text-align: left; width: 250px;">Total Keseluruhan</th>
                    <th style="text-align: right; width: 150px;">Jumlah</th>
                    <th style="text-align: right; width: 200px;">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Grand Total</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalQty }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($grandTotalPrice) }}</td>
                </tr>
            </tbody>
        </table>
    @endif

</body>

</html>
