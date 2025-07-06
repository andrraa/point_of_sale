@extends('layouts.app')

@section('title', 'Log Stok Barang')

@section('navTitle', 'Stok Log: ' . ucwords(strtolower($stock->stock_name)))

@section('content')
    <div class="mb-4 w-fit">
        <a href="{{ route('stock.index') }}">
            <div class="flex items-center gap-2 px-4 py-2 rounded-md border text-sm border-gray-400">
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                <span>Kembali</span>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="stock-log-table" class="w-full min-w-max">
            <thead class="!text-[13px] !tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Kode Stok</th>
                    <th class="p-3 bg-gray-100">Nama Stok</th>
                    <th class="p-3 bg-gray-100">Jumlah</th>
                    <th class="p-3 bg-gray-100">Keterangan</th>
                    <th class="p-3 bg-gray-100">Pengguna</th>
                    <th class="p-3 bg-gray-100">Tanggal</th>
                </tr>
            </thead>
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
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock.stock_code',
                        name: 'stock.stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-blue-500'
                    },
                    {
                        data: 'stock.stock_name',
                        name: 'stock.stock_name',
                        class: 'tracking-wide !text-xs !text-gray-900 line-clamp-1'
                    },
                    {
                        data: 'stock_log_quantity',
                        name: 'stock_log_quantity',
                        class: 'tracking-wide !text-xs !text-gray-900',
                        render: function(data, type, row) {
                            if (row.stock_log_status === '0') {
                                return `<span class="text-red-500 font-bold">-${data} pcs</span>`;
                            } else if (row.stock_log_status === '1') {
                                return `<span class="text-red-600 font-bold">+${data} pcs</span>`;
                            } else {
                                return `<span>${data}</span>`;
                            }
                        }
                    },
                    {
                        data: 'stock_log_description',
                        name: 'stock_log_description',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                    },
                    {
                        data: 'user.full_name',
                        name: 'user.full_name',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                    },
                ],
                columnDefs: [{
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }],
            });
        });
    </script>
@endpush
