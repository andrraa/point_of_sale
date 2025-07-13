@extends('layouts.report')

@section('title', 'Laporan Penjualan')

@section('content')
    <h1>Laporan Penjualan</h1>
    <h2>Tanggal: {{ $formattedStartDate }} s.d {{ $formattedEndDate }}</h2>

    @foreach ($datas as $dataIndex => $data)
        <div class="report-wrapper">
            <h3>Invoice: {{ $data['invoice'] }}</h3>
            <p>Tanggal: {{ $data['date'] }}</p>

            @php
                $totalSubQty = 0;
                $totalSubCostPrice = 0;
                $totalSubGrossPrice = 0;
                $totalSubNettoPrice = 0;
                $totalSubDiscountAmount = 0;
                $totalSubProfit = 0;
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Qty (Pcs)</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual (Gross)</th>
                        <th>Harga Jual (Netto)</th>
                        <th>Diskon</th>
                        <th>Laba</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['items'] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['code'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['cost_price']) }}</td>
                            <td>Rp {{ number_format($item['total_price']) }}</td>
                            <td>Rp {{ number_format($item['sell_price']) }}</td>
                            <td>Rp {{ number_format($item['discount_amount']) }}</td>
                            <td>Rp {{ number_format($item['profit']) }}</td>
                        </tr>

                        @php
                            $totalSubQty += $item['quantity'];
                            $totalSubCostPrice += $item['cost_price'];
                            $totalSubGrossPrice += $item['total_price'];
                            $totalSubNettoPrice += $item['sell_price'];
                            $totalSubDiscountAmount += $item['discount_amount'];
                            $totalSubProfit += $item['profit'];
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;">Subtotal:</td>
                        <td>{{ $totalSubQty }}</td>
                        <td>Rp {{ number_format($totalSubCostPrice) }}</td>
                        <td>Rp {{ number_format($totalSubGrossPrice) }}</td>
                        <td>Rp {{ number_format($totalSubNettoPrice) }}</td>
                        <td>Rp {{ number_format($totalSubDiscountAmount) }}</td>
                        <td>Rp {{ number_format($totalSubProfit - $data['total_debt']) }}</td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: right;">Total Piutang (Debt):</td>
                        <td>Rp {{ number_format($data['total_debt']) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach

    <div class="report-wrapper">
        <h2>Grand Total</h2>
        <table>
            <thead>
                <tr>
                    <th>Total Quantity</th>
                    <th>Total Penjualan</th>
                    <th>Total Diskon</th>
                    <th>Total Laba</th>
                    <th>Total Piutang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totals['total_quantity'] }} pcs</td>
                    <td>Rp {{ number_format($totals['total_sell_price']) }}</td>
                    <td>Rp {{ number_format($totals['total_discount_amount']) }}</td>
                    <td>Rp {{ number_format($totals['total_profit']) }}</td>
                    <td>Rp {{ number_format($totals['total_debt']) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
