@extends('layouts.app')

@section('title', 'Pelanggan')

@section('navTitle', 'Daftar Pelanggan')

@section('content')
    <div class="mb-6 w-fit">
        <x-action-button :props="[
            'url' => route('customer.create'),
            'label' => 'Pelanggan Baru',
        ]" />
    </div>

    <div class="bg-white rounded-xl border border-gray-200 mb-4 p-4 shadow-lg">
        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Kategori',
                'required' => true,
            ]" />

            <x-form.select :props="[
                'id' => 'filter',
                'name' => 'filter',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$categories" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="customer-table" class="w-full min-w-max">
            <thead class="!text-[13px] tracking-wide text-left">
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
            const dataTableAction = window.DataTablesAction;

            let table = $(dataTableSelector).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer.index') }}",
                    data: function(d) {
                        d.category_id = $('#filter').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        class: 'font-semibold tracking-wider !text-xs'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        class: 'font-semibold tracking-wider !text-xs !text-blue-500'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.category.category_code} - ${row.category.category_name}`;
                        }
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data, type, row) {
                            return `${row.region.region_code} - ${row.region.region_name}`;
                        }
                    },
                    {
                        data: 'customer_status',
                        name: 'customer_status',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data) {
                            const label = data == 1 ? 'Aktif' : 'Tidak Aktif';
                            const color = data == 1 ? 'bg-blue-500' : 'bg-red-900';

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
                    target: [0, 4, -1],
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
