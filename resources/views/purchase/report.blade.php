@extends('layouts.report')

@section('title', 'Laporan Pembelian')

@section('content')
    <h1>Laporan Pembelian</h1>
    <h2>Tanggal: {{ $startDate }} s.d {{ $endDate }}</h2>

    @foreach ($datas as $data)
        <div class="report-wrapper">
            <h3>Invoice: {{ $data['invoice'] }}</h3>
            <p>Tanggal: {{ $data['date'] }}</p>

            @php
                $totalSubQty = 0;
                $totalSubPrice = 0;
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
                            <td>Rp {{ number_format($item['price']) }}</td>
                        </tr>

                        @php
                            $totalSubQty += $item['quantity'];
                            $totalSubPrice += $item['subtotal'];
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;">Subtotal:</td>
                        <td>{{ $totalSubQty }} pcs</td>
                        <td>Rp {{ number_format($totalSubPrice) }}</td>
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
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totals['total_quantity'] }} pcs</td>
                    <td>Rp {{ number_format($totals['total_price']) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
