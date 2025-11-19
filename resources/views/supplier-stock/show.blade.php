@extends('layouts.app')

@section('title', 'Supplier Stock')

@section('navTitle', 'Detail Supplier')

@section('content')
    <div class="mb-6 w-fit">
        <a href="{{ route('supplier-stock.index') }}">
            <div
                class="flex items-center gap-2 px-4 py-2 rounded-md text-sm bg-white shadow-lg hover:bg-gray-100 transition-colors duration-300 border border-gray-200">
                <i class="fa-solid fa-chevron-left text-xs"></i>
                <span>Kembali</span>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg px-4 py-6 border border-gray-200">
        {{-- CUSTOMER --}}
        <div class="mb-2 pb-2 border-b border-b-gray-200">
            <h2 class="text-sm tracking-wide text-blue-500 font-medium text-[15px]">Detail Pelanggan</h2>
        </div>

        <table class="w-full mb-4">
            <tr>
                <td class="w-[240px] py-1">Nama Supplier</td>
                <td>:</td>
                <td>{{ $supplierStock->ss_name }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">No. Handphone Supplier</td>
                <td>:</td>
                <td>{{ $supplierStock->ss_phone }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Alamat Supplier</td>
                <td>:</td>
                <td>{{ $supplierStock->ss_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1">Keterangan Supplier</td>
                <td>:</td>
                <td>{{ $supplierStock->ss_description ?? '-' }}</td>
            </tr>
        </table>

        {{-- CREDIT --}}
        <div class="mb-4 pb-2 border-b border-b-gray-200">
            <h2 class="text-sm tracking-wide text-blue-500 font-medium text-[15px]">Stock Barang</h2>
        </div>

        <table class="w-full mb-6">
            <thead>
                <tr class="border-b border-b-gray-200">
                    <th class="p-2 text-left text-[13px] tracking-wider bg-gray-100">#</th>
                    <th class="p-2 text-left text-[13px] tracking-wider bg-gray-100">Kode</th>
                    <th class="p-2 text-left text-[13px] tracking-wider bg-gray-100">Nama</th>
                    <th class="p-2 text-left text-[13px] tracking-wider bg-gray-100">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($supplierStock->stocks as $index => $stock)
                    <tr>
                        <td class="p-2 text-[13px] text-gray-900 text-left">
                            {{ $index + 1 }}
                        </td>
                        <td class="p-2 text-[13px] text-left text-blue-500">
                            {{ $stock->stock_code }}
                        </td>
                        <td class="p-2 text-[13px] text-gray-900 text-left">
                            {{ $stock->stock_name }}
                        </td>
                        <td class="p-2 text-[13px] text-gray-900 text-left">
                            {{ $stock->stock_total }} pcs
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-2 text-sm text-gray-900 text-left tracking-wide">
                            Tidak ada data stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
