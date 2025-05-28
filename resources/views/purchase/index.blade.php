@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Daftar Pembelian')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('purchase.create'),
            'label' => 'Pembelian Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="purchase-table" class="w-full min-w-max">
            <thead class="text-sm tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Invoice</th>
                    <th class="p-3 bg-gray-100">Pemasok</th>
                    <th class="p-3 bg-gray-100">Wilayah</th>
                    <th class="p-3 bg-gray-100">Total Barang</th>
                    <th class="p-3 bg-gray-100">Total Harga</th>
                    <th class="p-3 bg-gray-100">Tanggal</th>
                    <th class="p-3 bg-gray-100">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])

    <script type="module">
        $(document).ready(function() {
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;
            const dataTableSelector = "#purchase-table";

            const customFunction = window.CustomFunction;

            $(dataTableSelector).dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purchase.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'purchase_invoice',
                        name: 'purchase_invoice',
                        class: 'font-bold tracking-wide !text-xs !text-blue-900'
                    },
                    {
                        data: 'supplier.supplier_name',
                        name: 'supplier.supplier_name',
                        class: 'tracking-wide !text-xs !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.supplier.supplier_code} - ${row.supplier.supplier_name}`;
                        }
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wide !text-xs !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.region.region_code} - ${row.region.region_name}`;
                        }
                    },
                    {
                        data: 'total_items',
                        name: 'total_items',
                        class: 'tracking-wide !text-xs !text-gray-900',
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        class: 'tracking-wide !text-xs !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'tracking-wide !text-xs !text-gray-900',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        render: function(data) {
                            return dataTableAction(data, dataTableSelector);
                        }
                    },
                ],
                columnDefs: [{
                    target: [0, -1, 4, 5],
                    searchable: false,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
