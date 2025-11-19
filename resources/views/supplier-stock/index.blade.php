@extends('layouts.app')

@section('title', 'Supplier Stock')

@section('navTitle', 'Daftar Supplier')

@section('content')
    <div class="mb-6">
        <x-action-button :props="[
            'url' => route('supplier-stock.create'),
            'label' => 'Supplier Baru',
        ]" />
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="supplierStock-table" class="w-full min-w-max">
            <thead class="!text-[13px] tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Nama</th>
                    <th class="p-3 bg-gray-100">No. Handphone</th>
                    <th class="p-3 bg-gray-100">Alamat</th>
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
            const dataTableSelector = '#supplierStock-table';
            const dataTableAction = window.DataTablesAction;

            let table = $(dataTableSelector).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('supplier-stock.index') }}",
                },
                order: [
                    [0, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'ss_name',
                        name: 'ss_name',
                        class: 'font-semibold tracking-wide !text-xs !text-blue-500'
                    },
                    {
                        data: 'ss_phone',
                        name: 'ss_phone',
                        class: 'tracking-wide !text-xs !text-gray-900'
                    },
                    {
                        data: 'ss_address',
                        name: 'ss_address',
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
        });
    </script>
@endpush
