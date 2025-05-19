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
                    <th class="p-3 bg-gray-100">Nomor Invoice</th>
                    <th class="p-3 bg-gray-100">Kode Pemasok</th>
                    <th class="p-3 bg-gray-100">Nama Pemasok</th>
                    <th class="p-3 bg-gray-100">Kode Wilayah</th>
                    <th class="p-3 bg-gray-100">Nama Wilayah</th>
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
            const dataTableSelector = "#purchase-table";

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
                        class: 'font-medium tracking-wide !text-blue-900'
                    },
                    {
                        data: 'supplier.supplier_code',
                        name: 'supplier.supplier_code',
                        class: 'font-medium tracking-wide !text-black/90'
                    },
                    {
                        data: 'supplier.supplier_name',
                        name: 'supplier.supplier_name',
                        class: 'font-medium tracking-wide !text-black/90'
                    },
                    {
                        data: 'region.region_code',
                        name: 'region.region_code',
                        class: 'font-medium tracking-wide !text-black/90'
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'font-medium tracking-wide !text-black/90'
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
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
