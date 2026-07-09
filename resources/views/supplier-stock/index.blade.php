@extends('layouts.app')

@section('title', 'Supplier Stock')

@section('navTitle', 'Daftar Supplier')

@section('content')
    <div class="mb-4">
        <a href="{{ route('supplier-stock.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium tracking-wide border border-slate-800 hover:bg-white hover:text-slate-800 transition-all duration-200 shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Supplier Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <table id="supplierStock-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">No. Handphone</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Alamat</th>
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
                        class: 'font-semibold tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'ss_phone',
                        name: 'ss_phone',
                        class: 'tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'ss_address',
                        name: 'ss_address',
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
        });
    </script>
@endpush
