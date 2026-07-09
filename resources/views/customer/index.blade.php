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

    <div class="bg-white rounded-xl border border-slate-200 mb-4 p-5 shadow-sm">
        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Kategori',
                'required' => true,
                'class' => 'text-slate-700 font-medium text-sm',
            ]" />

            <x-form.select :props="[
                'id' => 'filter',
                'name' => 'filter',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$categories" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <table id="customer-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kategori</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Wilayah</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Status</th>
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
                order: [
                    [2, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        class: 'font-semibold tracking-wider !text-xs'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        class: 'font-semibold tracking-wider !text-xs !text-slate-800'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wider !text-xs !text-slate-700',
                        render: function(data, type, row) {
                            return `${row.category.category_code} - ${row.category.category_name}`;
                        }
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wider !text-xs !text-slate-700',
                        render: function(data, type, row) {
                            return `${row.region.region_code} - ${row.region.region_name}`;
                        }
                    },
                    {
                        data: 'customer_status',
                        name: 'customer_status',
                        class: 'tracking-wider !text-xs',
                        render: function(data) {
                            const label = data == 1 ? 'Aktif' : 'Tidak Aktif';
                            const color = data == 1 ? 'bg-emerald-500' : 'bg-slate-400';

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
