@extends('layouts.app')

@section('title', 'Stok Barang')

@section('navTitle', 'Daftar Stok')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('stock.create'),
            'label' => 'Stok Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="stock-table" class="w-full min-w-max">
            <thead class="text-sm tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Kode Stok</th>
                    <th class="p-3 bg-gray-100">Nama Stok</th>
                    <th class="p-3 bg-gray-100">Total Stok</th>
                    <th class="p-3 bg-gray-100">Stok Tersedia</th>
                    <th class="p-3 bg-gray-100">Stok Masuk</th>
                    <th class="p-3 bg-gray-100">Stok Keluar</th>
                    <th class="p-3 bg-gray-100">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js'])

    <script type="module">
        $(document).ready(function() {
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;

            $('#stock-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('stock.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock_code',
                        name: 'stock_code',
                        class: 'font-bold tracking-wide text-blue-900'
                    },
                    {
                        data: 'stock_name',
                        name: 'stock_name',
                        class: 'font-medium tracking-wide text-gray-400'
                    },
                    {
                        data: 'stock_total',
                        name: 'stock_total',
                        class: 'font-medium tracking-wide'
                    },
                    {
                        data: 'stock_current',
                        name: 'stock_current',
                        class: 'font-medium tracking-wide text-blue-500'
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in',
                        class: 'font-medium tracking-wide text-green-500'
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out',
                        class: 'font-medium tracking-wide text-red-500'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        render: function(data) {
                            return dataTableAction(data, '#stock-table');
                        }
                    },
                ],
                columnDefs: [{
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
