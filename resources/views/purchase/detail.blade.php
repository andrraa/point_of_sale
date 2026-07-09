@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Detail Pembelian')

@section('content')
    <div class="mb-4 w-fit">
        <a href="{{ route('purchase.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-4">
        <div class="mb-2">
            <h1 class="font-semibold text-base text-slate-800">
                Nomor Invoice: {{ $purchase['purchase_invoice'] }}
            </h1>
            <p class="text-sm text-slate-500">
                Tanggal Pembelian: {{ $purchase['created_at'] }} WIB
            </p>
        </div>

        <div class="h-px bg-slate-200 mt-4 mb-4"></div>

        <div class="space-y-4">
            {{-- SUPPLIER --}}
            <div>
                <h2 class="text-sm font-semibold text-slate-700 mb-1">Supplier / Pemasok:</h2>
                <p class="text-sm text-slate-600">
                    {{ $purchase['supplier']['supplier_code'] }} -
                    {{ $purchase['supplier']['supplier_name'] }}
                </p>
                <p class="text-sm text-slate-600">{{ $purchase['supplier']['supplier_address'] }}</p>
                <p class="text-sm text-slate-600">
                    {{ $purchase['supplier']['region']['region_code'] }} -
                    {{ $purchase['supplier']['region']['region_name'] }}
                </p>
            </div>

            {{-- REGION --}}
            <div>
                <h2 class="text-sm font-semibold text-slate-700 mb-1">Region / Wilayah:</h2>
                <p class="text-sm text-slate-600">
                    {{ $purchase['region']['region_code'] }} -
                    {{ $purchase['region']['region_name'] }}
                </p>
            </div>

            {{-- STOCK --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="text-left text-xs bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <td class="p-2 tracking-wide">Kode Barang</td>
                            <td class="p-2 tracking-wide">Nama Barang</td>
                            <td class="p-2 tracking-wide">Harga Beli</td>
                            <td class="p-2 tracking-wide">Jumlah</td>
                            <td class="p-2 tracking-wide">Total Harga</td>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($purchase['details'] as $detail)
                            @php
                                $totalEach = $detail['purchase_detail_price'] * $detail['purchase_detail_quantity'];
                            @endphp

                            @if (isset($detail['stock']) && !empty($detail['stock']))
                                <tr>
                                    <td class="p-2 text-sm text-slate-700">
                                        {{ $detail['stock']['stock_code'] }}
                                    </td>
                                    <td class="p-2 text-sm text-slate-700">
                                        {{ $detail['stock']['stock_name'] }}
                                    </td>
                                    <td class="p-2 text-sm text-slate-700">
                                        Rp {{ number_format($detail['purchase_detail_price']) }}
                                    </td>
                                    <td class="p-2 text-sm text-slate-700">
                                        {{ $detail['purchase_detail_quantity'] }} pcs
                                    </td>
                                    <td class="p-2 text-sm text-slate-700">
                                        Rp {{ number_format($totalEach) }}
                                    </td>
                                </tr>

                                @php
                                    $total += $totalEach;
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-slate-200">
                            <td class="p-2 text-sm"></td>
                            <td class="p-2 text-sm"></td>
                            <td class="p-2 text-sm"></td>
                            <td class="p-2 text-sm font-medium text-slate-700">Total</td>
                            <td class="p-2 text-sm font-bold text-slate-800">
                                Rp {{ number_format($total) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
