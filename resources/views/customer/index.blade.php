@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Daftar Pelanggan')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('customer.create'),
            'label' => 'Pelanggan Baru',
        ]" />
    </div>

    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="customer-table" class="w-full min-w-max">
            <thead class="text-sm tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Nama</th>
                    <th class="p-3 bg-gray-100">Kategori</th>
                    <th class="p-3 bg-gray-100">Wilayah</th>
                    <th class="p-3 bg-gray-100">Status</th>
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
            const dataTableSelector = '#customer-table';
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;

            $(dataTableSelector).dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        class: 'font-semibold tracking-wider !text-sm !text-blue-900'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wider !text-sm !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.category.category_code} - ${row.category.category_name}`;
                        }
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wider !text-sm !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.region.region_code} - ${row.region.region_name}`;
                        }
                    },
                    {
                        data: 'customer_status',
                        name: 'customer_status',
                        class: 'tracking-wider !text-sm !text-gray-900',
                        render: function(data) {
                            const label = data == 1 ? 'Aktif' : 'Tidak Aktif';
                            const color = data == 1 ? 'bg-blue-900' : 'bg-red-900';

                            return `
                                <span class="text-xs py-1 px-2 font-medium rounded-md text-white ${color}">
                                    ${label}
                                </span>
                            `;
                        }
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
