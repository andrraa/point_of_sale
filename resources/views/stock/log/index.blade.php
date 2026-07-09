@extends('layouts.app')

@section('title', 'Log Stok')

@section('navTitle', 'Log Stok: ' . ucwords(strtolower($stock->stock_name)))

@section('content')
    <div class="mb-4 w-fit">
        <a href="{{ route('stock.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600 w-fit">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>
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
                @php
                    $today = \Carbon\Carbon::now()->toDateString();
                @endphp

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
        <table id="stock-log-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kode Stok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama Stok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Jumlah</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Keterangan</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Pengguna</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Tanggal</th>
                </tr>
            </thead>
            <tfoot class="!text-xs !tracking-wide !font-medium">
                <tr class="bg-slate-50">
                    <td colspan="3" class="p-2 !text-center italic text-slate-500">Total Stok Keluar</td>
                    <td id="total_quantity_out" class="p-2 text-slate-700"></td>
                    <td colspan="3" class="p-2"></td>
                </tr>
                <tr class="bg-slate-100/50">
                    <td colspan="3" class="p-2 !text-center italic text-slate-500">Total Stok Masuk</td>
                    <td id="total_quantity_in" class="p-2 text-slate-700"></td>
                    <td colspan="3" class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])

    <script type="module">
        $(document).ready(function() {
            const dataTableAction = window.DataTablesAction;
            const customFunction = window.CustomFunction;

            const baseUrl = "{{ url('/stock/log') }}";
            const stock = @json($stock);
            const url = `${baseUrl}/${stock.stock_id}`;

            let table = $('#stock-log-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
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
                        data: 'stock.stock_code',
                        name: 'stock.stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-slate-800'
                    },
                    {
                        data: 'stock.stock_name',
                        name: 'stock.stock_name',
                        class: 'tracking-wide !text-xs !text-slate-700 line-clamp-1'
                    },
                    {
                        data: 'stock_log_quantity',
                        name: 'stock_log_quantity',
                        class: 'tracking-wide !text-xs',
                        render: function(data, type, row) {
                            if (row.stock_log_status === '0') {
                                return `<span class="text-red-500 font-bold">-${data} pcs</span>`;
                            } else if (row.stock_log_status === '1') {
                                return `<span class="text-emerald-600 font-bold">+${data} pcs</span>`;
                            } else {
                                return `<span>${data}</span>`;
                            }
                        }
                    },
                    {
                        data: 'stock_log_description',
                        name: 'stock_log_description',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                    },
                    {
                        data: 'user.full_name',
                        name: 'user.full_name',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                    },
                ],
                columnDefs: [{
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }],
                drawCallback: function(settings) {
                    const json = settings.json;
                    const quantityOut = json.total_quantity_out;
                    const quantityIn = json.total_quantity_in;

                    if (json) {
                        $('#total_quantity_out').html(`${quantityOut} pcs`);
                        $('#total_quantity_in').html(`${quantityIn} pcs`);
                    }
                }
            });

            $('#filter-button').on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
