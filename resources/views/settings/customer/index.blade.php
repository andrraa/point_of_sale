@extends('layouts.app')

@section('title', 'Kategori Pelanggan')

@section('navTitle', 'Kategori Pelanggan')

@section('content')
    <div class="flex h-full max-h-full overflow-hidden gap-4">
        @include('partials.widget.sidebar')

        <main class="flex-1 h-full overflow-y-auto">
            <div class="mb-5">
                <h1 class="text-base font-semibold text-slate-800">Daftar Kategori Pelanggan</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola kategori pelanggan</p>
            </div>

            <div class="mb-5">
                <x-action-button :props="[
                    'url' => route('customer-category.create'),
                    'label' => 'Kategori Baru',
                ]" />
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="p-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Level Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($customerCategories as $index => $category)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="p-3 text-slate-700">{{ $category->category_code }}</td>
                                    <td class="p-3 text-slate-700">{{ $category->category_name }}</td>
                                    <td class="p-3 text-slate-700">{{ $category->category_price_level }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection
