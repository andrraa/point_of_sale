@extends('layouts.app')

@section('title', 'Supplier')

@section('navTitle', 'Daftar Pemasok')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('supplier.create'),
            'label' => 'Pemasok Baru',
        ]" />
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-4 p-4">
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
            ]" :options="$regions" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="supplier-table" class="w-full min-w-max">
            <thead class="!text-[13px] tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Kode Pemasok</th>
                    <th class="p-3 bg-gray-100">Nama Pemasok</th>
                    <th class="p-3 bg-gray-100">Wilayah Pemasok</th>
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
            const dataTableSelector = '#supplier-table';
            const dataTableAction = window.DataTablesAction;

            let table = $(dataTableSelector).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('supplier.index') }}",
                    data: function(d) {
                        d.region_id = $('#filter').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'supplier_code',
                        name: 'supplier_code',
                        class: 'font-semibold tracking-wide !text-xs !text-blue-500'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name',
                        class: 'tracking-wide !text-xs !text-gray-900'
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wide !text-xs !text-gray-900'
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

            $('#filter').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
