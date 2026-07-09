@extends('layouts.app')

@section('title', 'Supplier Stock')

@section('navTitle', 'Detail Supplier')

@section('content')
    <div class="mb-4 w-fit">
        <a href="{{ route('supplier-stock.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        {{-- SUPPLIER INFO --}}
        <div class="mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-800">Data Supplier</h2>
        </div>

        <table class="w-full mb-6">
            <tr>
                <td class="w-[240px] py-1.5 text-sm text-slate-600">Nama Supplier</td>
                <td class="py-1.5 text-sm text-slate-700">:</td>
                <td class="py-1.5 text-sm text-slate-700 font-medium">{{ $supplierStock->ss_name }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1.5 text-sm text-slate-600">No. Handphone Supplier</td>
                <td class="py-1.5 text-sm text-slate-700">:</td>
                <td class="py-1.5 text-sm text-slate-700 font-medium">{{ $supplierStock->ss_phone }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1.5 text-sm text-slate-600">Alamat Supplier</td>
                <td class="py-1.5 text-sm text-slate-700">:</td>
                <td class="py-1.5 text-sm text-slate-700">{{ $supplierStock->ss_address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="w-[240px] py-1.5 text-sm text-slate-600">Keterangan Supplier</td>
                <td class="py-1.5 text-sm text-slate-700">:</td>
                <td class="py-1.5 text-sm text-slate-700">{{ $supplierStock->ss_description ?? '-' }}</td>
            </tr>
        </table>

        {{-- STOCK --}}
        <div class="mb-4 pb-3 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-800">Stok Barang</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="p-2 text-left text-xs tracking-wider text-slate-600 bg-slate-50 font-semibold">#</th>
                        <th class="p-2 text-left text-xs tracking-wider text-slate-600 bg-slate-50 font-semibold">Kode</th>
                        <th class="p-2 text-left text-xs tracking-wider text-slate-600 bg-slate-50 font-semibold">Nama</th>
                        <th class="p-2 text-left text-xs tracking-wider text-slate-600 bg-slate-50 font-semibold">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($supplierStock->stocks as $index => $stock)
                        <tr>
                            <td class="p-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                            <td class="p-2 text-sm text-slate-800 font-medium">{{ $stock->stock_code }}</td>
                            <td class="p-2 text-sm text-slate-700">{{ $stock->stock_name }}</td>
                            <td class="p-2 text-sm text-slate-700">{{ $stock->stock_total }} pcs</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-sm text-slate-500 text-center">Tidak ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
