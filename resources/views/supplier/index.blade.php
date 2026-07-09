@extends('layouts.app')

@section('title', 'Pemasok')

@section('navTitle', 'Daftar Pemasok')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('supplier.create'),
            'label' => 'Pemasok Baru',
        ]" />
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-4 p-5">
        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Wilayah',
                'required' => true,
                'class' => 'text-slate-700 font-medium text-sm',
            ]" />

            <x-form.select :props="[
                'id' => 'filter',
                'name' => 'filter',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$regions" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <table id="supplier-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kode Pemasok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama Pemasok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Wilayah</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Aksi</th>
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
                order: [
                    [3, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'supplier_code',
                        name: 'supplier_code',
                        class: 'font-semibold tracking-wide !text-xs !text-slate-800'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name',
                        class: 'tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wide !text-xs !text-slate-700'
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
