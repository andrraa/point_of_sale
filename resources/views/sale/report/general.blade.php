@extends('layouts.report')

@section('title', 'Laporan Penjualan')

@section('content')
    <h1>Laporan Penjualan Umum</h1>
    <h2>Tanggal: {{ $formattedStartDate }} s.d {{ $formattedEndDate }}</h2>

    @if (!empty($categoryName))
        <h3>Kategori: {{ $categoryName }}</h3>
    @endif

    <div class="report-wrapper" style="margin-top: 20px;">
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Qty</th>
                    <th>Total Penjualan</th>
                    <th>Total Diskon</th>
                    <th>Total Laba</th>
                    <th>Total Piutang</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotalQty = 0;
                    $grandTotalSell = 0;
                    $grandTotalDiscount = 0;
                    $grandTotalProfit = 0;
                    $grandTotalDebt = 0;
                @endphp

                @foreach ($monthlyData as $data)
                    <tr>
                        <td>{{ $data['month'] }}</td>
                        <td>{{ $data['total_quantity'] }} pcs</td>
                        <td>Rp {{ number_format($data['total_sell_price']) }}</td>
                        <td>Rp {{ number_format($data['total_discount_amount']) }}</td>
                        <td>Rp {{ number_format($data['total_profit']) }}</td>
                        <td>Rp {{ number_format($data['total_debt']) }}</td>
                    </tr>

                    @php
                        $grandTotalQty += $data['total_quantity'];
                        $grandTotalSell += $data['total_sell_price'];
                        $grandTotalDiscount += $data['total_discount_amount'];
                        $grandTotalProfit += $data['total_profit'];
                        $grandTotalDebt += $data['total_debt'];
                    @endphp
                @endforeach

                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td>Total Keseluruhan</td>
                    <td>{{ $grandTotalQty }} pcs</td>
                    <td>Rp {{ number_format($grandTotalSell) }}</td>
                    <td>Rp {{ number_format($grandTotalDiscount) }}</td>
                    <td>Rp {{ number_format($grandTotalProfit) }}</td>
                    <td>Rp {{ number_format($grandTotalDebt) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
