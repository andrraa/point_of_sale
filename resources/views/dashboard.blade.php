@extends('layouts.app')

@section('title', 'Dashboard')

@section('navTitle', 'Dashboard')

@section('content')
    <div class="flex items-center gap-4">
        <div class="bg-white rounded-xl shadow-md p-4 max-w-full w-full border border-gray-200 min-h-[350px]">
            <div class="flex items-center justify-between">
                <h2 class="text-sm uppercase tracking-wide font-medium text-black/80">
                    Penjualan Terbaru
                </h2>

                <a href="{{ route('sale.index') }}"
                    class="text-sm px-4 py-1.5 font-medium text-white bg-blue-500 rounded-lg shadow-md tracking-wide uppercase hover:bg-blue-600 transition-colors duration-300">
                    Detail
                </a>
            </div>

            <table class="table w-full mt-6">
                <thead class="bg-gray-200 text-left !text-sm">
                    <tr>
                        <th class="p-2 tracking-wide font-medium">No.</th>
                        <th class="p-2 tracking-wide font-medium">Invoice</th>
                        <th class="p-2 tracking-wide font-medium">Total</th>
                        <th class="p-2 tracking-wide font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-left !text-xs">
                    @forelse ($sales as $index => $sale)
                        <tr class="even:bg-gray-100 !text-xs">
                            <td class="p-2 tracking-wide">{{ $index + 1 }}</td>
                            <td class="p-2 tracking-wide">
                                {{ "$stock->stock_code - $stock->stock_name" }}
                            </td>
                            <td class="p-2 tracking-wide">{{ $stock->stock_out }} pcs</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 tracking-wide">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 max-w-full w-full border border-gray-200 min-h-[350px]">
            <div class="flex items-center justify-between">
                <h2 class="text-sm uppercase tracking-wide font-medium text-black/80">
                    Stok Terlaris
                </h2>

                <a href="{{ route('stock.index') }}"
                    class="text-sm px-4 py-1.5 font-medium text-white bg-blue-500 rounded-lg shadow-md tracking-wide uppercase hover:bg-blue-600 transition-colors duration-300">
                    Detail
                </a>

            </div>

            <table class="table w-full mt-6">
                <thead class="bg-gray-200 text-left !text-sm">
                    <tr>
                        <th class="p-2 tracking-wide font-medium">No.</th>
                        <th class="p-2 tracking-wide font-medium">Barang</th>
                        <th class="p-2 tracking-wide font-medium">Terjual</th>
                    </tr>
                </thead>
                <tbody class="text-left !text-xs">
                    @forelse ($stocks as $index => $stock)
                        <tr class="even:bg-gray-100 !text-xs">
                            <td class="p-2 tracking-wide">{{ $index + 1 }}</td>
                            <td class="p-2 tracking-wide">
                                {{ "$stock->stock_code - $stock->stock_name" }}
                            </td>
                            <td class="p-2 tracking-wide">{{ $stock->stock_out }} pcs</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 tracking-wide">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
