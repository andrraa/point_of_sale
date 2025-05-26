@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Daftar Penjualan')

@section('content')
    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="sale-table" class="w-full min-w-max">
            <thead class="text-sm tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Invoice</th>
                    <th class="p-3 bg-gray-100">Pelanggan</th>
                    <th class="p-3 bg-gray-100">Total Harga</th>
                    <th class="p-3 bg-gray-100">Total Bayar</th>
                    <th class="p-3 bg-gray-100">Tanggal Penjualan</th>
                    <th class="p-3 bg-gray-100">Status</th>
                    <th class="p-3 bg-gray-100">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])

    <script type="module">
        $(document).ready(function() {
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;
            const dataTableSelector = "#sale-table";

            const customFunction = window.CustomFunction;

            $(dataTableSelector).dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('sale.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'sales_invoice',
                        name: 'sales_invoice',
                        class: 'font-bold tracking-wider !text-blue-900'
                    },
                    {
                        data: 'customer.customer_name',
                        name: 'customer.customer_name',
                        class: 'tracking-wider !text-gray-900',
                    },
                    {
                        data: 'sales_total_price',
                        name: 'sales_total_price',
                        class: 'tracking-wider !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'sales_total_payment',
                        name: 'sales_total_payment',
                        class: 'tracking-wider !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'tracking-wider !text-gray-900',
                    },
                    {
                        data: 'sales_status',
                        name: 'sales_status',
                        class: 'tracking-wider !text-gray-900',
                        render: function(data, type, row) {
                            const statusMap = {
                                1: 'Lunas',
                                5: 'Kredit',
                                0: 'Dibatalkan'
                            };

                            const status = statusMap[data] || '';

                            let creditInfo = '';
                            if (row.credit) {
                                const creditStatus = row.credit.customer_credit_status == 1 ?
                                    'Lunas' : 'Belum Lunas';
                                creditInfo =
                                    `<span class="text-[13px] text-green-700 font-medium">Status Kredit: ${creditStatus}</span>`;
                            }

                            const color = data == 0 ? 'text-red-700' : 'text-blue-700';

                            return `
                                <div class="flex flex-col gap-1">
                                    <span class="text-[13px] ${color} font-medium">Status Bayar: ${status}</span>
                                    ${creditInfo}
                                </div>
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
                    target: [0, -1, 4, 5],
                    searchable: false,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
