@extends('layouts.report')

@section('title', 'Laporan Stok')

@section('content')
    @php
        $grandTotalQty = 0;
        $grandTotalOut = 0;
        $grandTotalRemaining = 0;
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
                        <th style="width: 70px;">No.</th>
                        <th style="width: 300px;">Barang</th>
                        <th style="width: 70px;">Stok Total</th>
                        <th style="width: 70px;">Stok Keluar</th>
                        <th style="width: 70px;">Stok Sisa</th>
                        <th style="width: 70px;">Harga Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalQuantity = 0;
                        $totalOut = 0;
                        $totalRemaining = 0;
                        $totalPrice = 0;
                    @endphp

                    @foreach ($stock as $i => $item)
                        @php
                            $remaining = $item->stock_in - $item->stock_out;
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ "$item->stock_code - $item->stock_name" }}</td>
                            <td>{{ $item->stock_total }} pcs</td>
                            <td>{{ $item->stock_out }} pcs</td>
                            <td>{{ $remaining }} pcs</td>
                            <td>Rp {{ number_format($item->stock_purchase_price) }}</td>
                        </tr>
                        @php
                            $totalQuantity += $item->stock_total;
                            $totalOut += $item->stock_out;
                            $totalRemaining += $remaining;
                            $totalPrice += $item->stock_purchase_price * $item->stock_out;
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="2" style="text-align: center;"><em>Subtotal</em></td>
                        <td><strong>{{ $totalQuantity }} pcs</strong></td>
                        <td><strong>{{ $totalOut }} pcs</strong></td>
                        <td><strong>{{ $totalRemaining }} pcs</strong></td>
                        <td><strong>Rp {{ number_format($totalPrice) }}</strong></td>
                    </tr>
                </tbody>
            </table>

            @php
                $grandTotalQty += $totalQuantity;
                $grandTotalOut += $totalOut;
                $grandTotalRemaining += $totalRemaining;
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
                    <th style="text-align: right; width: 150px;">Stok Sisa</th>
                    <th style="text-align: right; width: 200px;">Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Grand Total</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalQty }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalOut }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">{{ $grandTotalRemaining }} pcs</td>
                    <td style="text-align: right; font-weight: bold;">
                        Rp {{ number_format($grandTotalPrice) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
@endsection
