@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Detail Pembelian')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <div>
            <h1 class="font-semibold text-[16px] mb-1 text-blue-500">
                Nomor Invoice: {{ $purchase['purchase_invoice'] }}
            </h1>
            <h1 class="text-black/90 text-sm">
                Tanggal Pembelian: {{ $purchase['created_at'] }} WIB
            </h1>
        </div>

        <div class="h-0.5 bg-gray-200 mt-4 mb-4"></div>

        <div class="flex flex-col">
            {{-- SUPPLIER --}}
            <div class="mb-4">
                <h1 class="font-semibold text-[16px] text-blue-500 mb-1">
                    Supplier / Pemasok:
                </h1>
                <h1 class="text-sm text-gray-900 mb-0.5">
                    {{ $purchase['supplier']['supplier_code'] }} -
                    {{ $purchase['supplier']['supplier_name'] }}
                </h1>
                <h1 class="text-sm text-gray-900 mb-0.5">
                    {{ $purchase['supplier']['supplier_address'] }}
                </h1>
                <h1 class="text-sm text-gray-900 mb-0.5">
                    {{ $purchase['supplier']['region']['region_code'] }} -
                    {{ $purchase['supplier']['region']['region_name'] }}
                </h1>
            </div>

            {{-- REGION --}}
            <div class="mb-4">
                <h1 class="font-semibold text-[16px] text-blue-500 mb-1">
                    Region / Wilayah:
                </h1>
                <h1 class="text-sm text-gray-900 mb-0.5">
                    {{ $purchase['region']['region_code'] }} -
                    {{ $purchase['region']['region_name'] }}
                </h1>
            </div>

            {{-- STOCK --}}
            <div class="mb-6    ">
                <table class="w-full">
                    <thead class="text-left text-sm bg-gray-100 font-medium">
                        <tr>
                            <td class="p-2 tracking-wide">Kode Barang</td>
                            <td class="p-2 tracking-wide">Nama Barang</td>
                            <td class="p-2 tracking-wide">Harga Beli</td>
                            <td class="p-2 tracking-wide">Jumlah</td>
                            <td class="p-2 tracking-wide">Total Harga</td>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($purchase['details'] as $detail)
                            @php
                                $totalEach = $detail['purchase_detail_price'] * $detail['purchase_detail_quantity'];
                            @endphp

                            <tr class="{{ $loop->last ? 'border-b border-b-gray-100' : '' }}">
                                <td class="p-2 tracking-wider !text-sm text-gray-900">
                                    {{ $detail['stock']['stock_code'] }}
                                </td>
                                <td class="p-2 tracking-wider !text-sm text-gray-900">
                                    {{ $detail['stock']['stock_name'] }}
                                </td>
                                <td class="p-2 tracking-wider !text-sm text-gray-900">
                                    Rp {{ number_format($detail['purchase_detail_price']) }}
                                </td>
                                <td class="p-2 tracking-wider !text-sm text-gray-900">
                                    {{ $detail['purchase_detail_quantity'] }} pcs
                                </td>
                                <td class="p-2 tracking-wider !text-sm text-gray-900">
                                    Rp
                                    {{ number_format($totalEach) }}
                                </td>
                            </tr>

                            @php
                                $total += $totalEach;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-b border-b-gray-100">
                            <td class="p-2 tracking-wider !text-sm text-gray-900"></td>
                            <td class="p-2 tracking-wider !text-sm text-gray-900"></td>
                            <td class="p-2 tracking-wider !text-sm text-gray-900"></td>
                            <td class="p-2 tracking-wider !text-sm text-gray-900"></td>
                            <td class="p-2 tracking-wider !text-sm text-blue-500 font-bold">
                                Rp {{ number_format($total) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <a href="{{ route('purchase.index') }}"
                class="w-fit px-4 py-2 rounded-lg border border-gray-300 text-sm tracking-wider font-semibold hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
