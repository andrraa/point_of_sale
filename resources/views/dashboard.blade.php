@extends('layouts.app')

@section('title', 'Dashboard')

@section('navTitle', 'Dashboard')

@section('content')
    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pendapatan Hari Ini</span>
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-trend-up text-emerald-600 text-sm"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($revenueToday, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Transaksi Hari Ini</span>
                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-slate-800 text-sm"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $salesCountToday }}</h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Piutang</span>
                <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i class="fa-solid fa-hand-holding-dollar text-amber-600 text-sm"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalDebt, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Stok Menipis</span>
                <div class="w-9 h-9 rounded-lg bg-red-100 flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-slate-800' }}">
                {{ $lowStockCount }} item
            </h3>
        </div>
    </div>

    {{-- SECONDARY STATS ROW --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-boxes-stacked text-indigo-600 text-sm"></i>
            </div>
            <div>
                <span class="text-xs text-slate-500">Total Stok</span>
                <h4 class="text-lg font-semibold text-slate-800">{{ number_format($totalStockItems, 0, ',', '.') }} item</h4>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-users text-teal-600 text-sm"></i>
            </div>
            <div>
                <span class="text-xs text-slate-500">Total Pelanggan</span>
                <h4 class="text-lg font-semibold text-slate-800">{{ number_format($totalCustomers, 0, ',', '.') }}</h4>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-store text-cyan-600 text-sm"></i>
            </div>
            <div>
                <span class="text-xs text-slate-500">Total Barang</span>
                <h4 class="text-lg font-semibold text-slate-800">{{ number_format($totalStockItems, 0, ',', '.') }} unit</h4>
            </div>
        </div>
    </div>

    {{-- TABLES ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- PENJUALAN TERBARU --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-700">Penjualan Terbaru</h2>
                <a href="{{ route('sale.index') }}"
                    class="text-xs px-3 py-1.5 font-medium text-white bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            <div class="p-5">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 pr-2">No.</th>
                            <th class="pb-3 pr-2">Invoice</th>
                            <th class="pb-3 pr-2">Total</th>
                            <th class="pb-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($sales as $index => $sale)
                            <tr class="border-t border-slate-100">
                                <td class="py-2.5 pr-2 text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-2.5 pr-2 font-medium text-slate-800">{{ $sale->sales_invoice }}</td>
                                <td class="py-2.5 pr-2 text-slate-700">Rp {{ number_format($sale->sales_total_price, 0, ',', '.') }}</td>
                                <td class="py-2.5 text-slate-500 text-xs">{{ $sale->formatted_created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-slate-400 text-sm">Tidak ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- STOK TERLARIS --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-700">Stok Terlaris</h2>
                <a href="{{ route('stock.index') }}"
                    class="text-xs px-3 py-1.5 font-medium text-white bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            <div class="p-5">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 pr-2">No.</th>
                            <th class="pb-3 pr-2">Barang</th>
                            <th class="pb-3">Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($stocks as $index => $stock)
                            <tr class="border-t border-slate-100">
                                <td class="py-2.5 pr-2 text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-2.5 pr-2 text-slate-700">{{ $stock->stock_code }} - {{ $stock->stock_name }}</td>
                                <td class="py-2.5 font-medium text-slate-700">{{ $stock->stock_out }} <span class="text-xs text-slate-400">pcs</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-slate-400 text-sm">Tidak ada data stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- LOW STOCK WARNING --}}
    @if ($lowStocks->isNotEmpty())
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm mt-4">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-sm"></i>
                    <h2 class="text-sm font-semibold text-slate-700">Peringatan Stok Menipis</h2>
                </div>
                <a href="{{ route('stock.index') }}"
                    class="text-xs px-3 py-1.5 font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition-colors duration-200">
                    Kelola Stok
                </a>
            </div>
            <div class="p-5">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 pr-2">No.</th>
                            <th class="pb-3 pr-2">Barang</th>
                            <th class="pb-3">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($lowStocks as $index => $stock)
                            <tr class="border-t border-slate-100">
                                <td class="py-2.5 pr-2 text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-2.5 pr-2 text-slate-700">{{ $stock->stock_code }} - {{ $stock->stock_name }}</td>
                                <td class="py-2.5 font-semibold {{ $stock->stock_total <= 2 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $stock->stock_total }} <span class="text-xs text-slate-400">pcs</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
