@extends('layouts.report')

@section('title', 'Laporan Pembelian')

@push('styles')
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .report-wrapper {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        thead tr {
            page-break-inside: avoid;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            font-weight: bold;
            background: #f2f2f2;
        }

        h1, h2, h3 {
            margin: 0 0 10px 0;
            page-break-after: avoid;
        }
    </style>
@endpush

@section('content')
    <h1>Laporan Pembelian</h1>
    <h2>Tanggal: {{ $startDate }} s.d {{ $endDate }}</h2>

    @foreach ($datas as $data)
        <div class="report-wrapper">
            <h3>Invoice: {{ $data['invoice'] }}</h3>
            <p>Tanggal: {{ \Carbon\Carbon::parse($data['date'])->format('d M Y') }}</p>

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
