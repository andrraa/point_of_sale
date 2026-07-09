@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Daftar Pembelian')

@section('content')
    @php
        $today = \Carbon\Carbon::now()->toDateString();
    @endphp

    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('purchase.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium tracking-wide border border-slate-800 hover:bg-white hover:text-slate-800 transition-all duration-200 shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Pembelian Baru</span>
        </a>

        <button id="open-report-modal" type="button"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white text-slate-700 text-sm font-medium tracking-wide border border-slate-300 hover:bg-slate-50 transition-all duration-200 shadow-sm cursor-pointer">
            <i class="fa-solid fa-file text-xs"></i>
            Laporan Pembelian
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-4 p-5">
        <div class="w-full">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Tanggal',
                'required' => true,
                'class' => 'text-slate-700 font-medium text-sm',
            ]" />

            <div class="flex items-center gap-4 pb-3">
                <input type="date" id="start_date" name="start_date"
                    class="px-4 py-2 w-full rounded-lg border border-slate-300 outline-none text-sm" value="{{ $today }}">

                <input type="date" id="end_date" name="end_date"
                    class="px-4 py-2 w-full rounded-lg border border-slate-300 outline-none text-sm" value="{{ $today }}">
            </div>

            <button id="filter-button"
                class="px-4 py-2 bg-slate-800 text-white text-sm rounded-lg tracking-wide font-medium hover:bg-slate-700 transition-colors duration-200 cursor-pointer">
                <i class="fa-solid fa-magnifying-glass text-xs mr-1"></i>
                Cari Data
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <table id="purchase-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Invoice</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Pemasok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Wilayah</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Total Barang</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Total Harga</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Tanggal</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tfoot class="!text-xs tracking-wide">
                <tr>
                    <td colspan="4" class="p-2 !text-center font-medium text-slate-600">Total</td>
                    <td id="total-quantity" class="p-2 font-medium text-slate-700"></td>
                    <td id="total-price" class="p-2 font-medium text-slate-700"></td>
                    <td colspan="2" class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @include('purchase.modal')
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script type="module">
        {!! $validator !!}

        $(document).ready(function() {
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;
            const dataTableSelector = "#purchase-table";

            const customFunction = window.CustomFunction;

            let table = $(dataTableSelector).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchase.index') }}",
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'purchase_invoice',
                        name: 'purchase_invoice',
                        class: 'font-bold tracking-wide !text-xs !text-slate-800'
                    },
                    {
                        data: 'supplier.supplier_name',
                        name: 'supplier.supplier_name',
                        class: 'tracking-wide !text-xs !text-slate-700',
                        render: function(data, type, row) {
                            return `${row.supplier.supplier_code} - ${row.supplier.supplier_name}`;
                        }
                    },
                    {
                        data: 'region.region_name',
                        name: 'region.region_name',
                        class: 'tracking-wide !text-xs !text-slate-700',
                        render: function(data, type, row) {
                            return `${row.region.region_code} - ${row.region.region_name}`;
                        }
                    },
                    {
                        data: 'total_items',
                        name: 'total_items',
                        class: 'tracking-wide !text-xs !text-slate-700',
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        class: 'tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'tracking-wide !text-xs !text-slate-700',
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
                }],
                drawCallback: function(settings) {
                    const json = settings.json;
                    const quantity = json.total_quantity;
                    const price = json.total_price;

                    if (json) {
                        $('#total-quantity').html(`${quantity} pcs`);
                        $('#total-price').html(`Rp ${customFunction.formatNumberToRupiah(price)}`);
                    }
                }
            });

            $('#filter-button').on('click', function() {
                table.ajax.reload();
            });

            $('#open-report-modal').on('click', function() {
                $('#modal-sale-report').removeClass('hidden').addClass('flex');
            });

            $('.modal-report-cancel').on('click', function() {
                $('#modal-sale-report').removeClass('flex').addClass('hidden');
            });
        });
    </script>
@endpush
