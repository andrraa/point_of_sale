@extends('layouts.app')

@section('title', 'Laporan')

@section('navTitle', 'Daftar Laporan')

@section('content')
    {{-- PENJUALAN --}}
    <div class="bg-white rounded-lg p-6 border border-gray-200 mb-4">
        <div class="border-b border-b-gray-200 pb-2 mb-2">
            <h2 class="text-blue-900 tracking-wide font-medium">Laporan Penjualan</h2>
        </div>

        <form method="POST" action="{{ route('report.sales') }}">
            @csrf
            <div class="mb-6 grid md:grid-cols-4 gap-4 items-end">
                <div>
                    <x-form.label :props="[
                        'for' => 'sale_start_date',
                        'label' => 'Tanggal Mulai',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'type' => 'date',
                        'id' => 'sale_start_date',
                        'name' => 'sale_start_date',
                        'value' => request('sale_start_date', $today),
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'sale_end_date',
                        'label' => 'Tanggal Akhir',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'type' => 'date',
                        'id' => 'sale_end_date',
                        'name' => 'sale_end_date',
                        'value' => request('sale_end_date', $today),
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'sale_type',
                        'label' => 'Tipe',
                        'required' => true,
                    ]" />
                    <x-form.select :props="[
                        'id' => 'sale_type',
                        'name' => 'sale_type',
                        'value' => null,
                        'class' => 'w-full',
                    ]" :options="[
                        'detail' => 'Laporan Detail',
                        // 'analyse' => 'Laporan Analisis',
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'sale_category',
                        'label' => 'Kategori',
                        'required' => true,
                    ]" />
                    <x-form.select :props="[
                        'id' => 'sale_category',
                        'name' => 'sale_category',
                        'value' => null,
                        'class' => 'w-full',
                    ]" :options="[
                        'all' => 'Semua',
                    ]" />
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-[10px] bg-blue-900 text-white tracking-wide font-medium rounded-md transition duration-200 hover:bg-blue-950">
                        Download
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- PEMBELIAN --}}
    <div class="bg-white rounded-lg p-6 border border-gray-200 mb-4">
        <div class="border-b border-b-gray-200 pb-2 mb-2">
            <h2 class="text-blue-900 tracking-wide font-medium">Laporan Pembelian</h2>
        </div>

        <form method="POST" action="{{ route('report.purchase') }}">
            @csrf
            <div class="mb-6 grid md:grid-cols-3 gap-4 items-end">
                <div>
                    <x-form.label :props="[
                        'for' => 'purchase_start_date',
                        'label' => 'Tanggal Mulai',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'type' => 'date',
                        'id' => 'purchase_start_date',
                        'name' => 'purchase_start_date',
                        'value' => request('purchase_start_date', $today),
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'purchase_end_date',
                        'label' => 'Tanggal Akhir',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'type' => 'date',
                        'id' => 'purchase_end_date',
                        'name' => 'purchase_end_date',
                        'value' => request('purchase_end_date', $today),
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'purchase_type',
                        'label' => 'Tipe',
                        'required' => true,
                    ]" />
                    <x-form.select :props="[
                        'id' => 'purchase_type',
                        'name' => 'purchase_type',
                        'value' => null,
                        'class' => 'w-full',
                    ]" :options="[
                        'detail' => 'Laporan Detail',
                        // 'analyse' => 'Laporan Analisis',
                    ]" />
                </div>

                {{-- <div>
                    <x-form.label :props="[
                        'for' => 'purchase_category',
                        'label' => 'Kategori',
                        'required' => true,
                    ]" />
                    <x-form.select :props="[
                        'id' => 'purchase_category',
                        'name' => 'purchase_category',
                        'value' => null,
                        'class' => 'w-full',
                    ]" :options="$categories" />
                </div> --}}

                <div>
                    <button type="submit"
                        class="w-full py-[10px] bg-blue-900 text-white tracking-wide font-medium rounded-md transition duration-200 hover:bg-blue-950">
                        Download
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
