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
        <div class="mb-4">
            <x-form.select :props="[
                'id' => 'filter',
                'name' => 'filter',
                'value' => null,
            ]" :options="$categories" />
        </div>

        <table id="stock-table" class="w-full min-w-max">
            <thead class="text-sm tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Kode Stok</th>
                    <th class="p-3 bg-gray-100">Nama Stok</th>
                    <th class="p-3 bg-gray-100">Kategori</th>
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

            let table = $('#stock-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stock.index') }}",
                    data: function(d) {
                        d.category_id = $('#filter').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock_code',
                        name: 'stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-blue-900'
                    },
                    {
                        data: 'stock_name',
                        name: 'stock_name',
                        class: 'tracking-wide !text-xs !text-gray-900 line-clamp-1'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wide !text-xs !text-gray-900'
                    },
                    {
                        data: 'stock_total',
                        name: 'stock_total',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_current',
                        name: 'stock_current',
                        class: 'font-medium tracking-wide !text-xs 1text-blue-500',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in',
                        class: 'font-medium tracking-wide !text-xs !text-green-500',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out',
                        class: 'font-medium tracking-wide !text-xs !text-red-500',
                        render: function(data) {
                            return `${data} pcs`;
                        }
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

            $('#filter').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
