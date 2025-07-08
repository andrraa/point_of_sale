@extends('layouts.app')

@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }

            #modal-container,
            #modal-container * {
                visibility: visible !important;
            }

            #modal-container {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 75mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
                display: block !important;
            }

            #modal-card {
                all: unset;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush


@section('title', 'Penjualan')

@section('navTitle', 'Daftar Penjualan')

@section('content')
    <div class="bg-white rounded-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="sale-table" class="w-full min-w-max">
            <thead class="!text-[13px] tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Invoice</th>
                    <th class="p-3 bg-gray-100">Pelanggan</th>
                    <th class="p-3 bg-gray-100">Total Harga</th>
                    <th class="p-3 bg-gray-100">Total Bayar</th>
                    <th class="p-3 bg-gray-100">Total Hutang</th>
                    <th class="p-3 bg-gray-100">Tanggal Penjualan</th>
                    <th class="p-3 bg-gray-100">Status</th>
                    <th class="p-3 bg-gray-100">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- MODAL --}}
    <div id="modal-container"
        class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full items-center justify-center hidden">
        <div id="modal-card"
            class="relative mx-auto p-4 border border-gray-300 w-full max-w-[400px] shadow-lg rounded-lg bg-white">
        </div>
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
                        class: 'font-bold !text-xs tracking-wider !text-blue-500'
                    },
                    {
                        data: 'customer.customer_name',
                        name: 'customer.customer_name',
                        class: 'tracking-wider !text-xs !text-gray-900',
                    },
                    {
                        data: 'sales_total_price',
                        name: 'sales_total_price',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'sales_total_payment',
                        name: 'sales_total_payment',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'sale_total_debt',
                        name: 'sale_total_debt',
                        class: 'tracking-wider !text-xs !text-gray-900',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'tracking-wider !text-xs !text-gray-900',
                    },
                    {
                        data: 'sales_status',
                        name: 'sales_status',
                        class: 'tracking-wider !text-xs !text-gray-900',
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
                                    `<span class="!text-xs text-green-700 font-medium">Status Kredit: ${creditStatus}</span>`;
                            }

                            const color = data == 0 ? 'text-red-700' : 'text-blue-700';

                            return `
                                <div class="flex flex-col gap-1">
                                    <span class="${color} !text-xs font-medium">${status}</span>
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

            // PRINT BUTTON
            const modalCard = $('#modal-card');
            const modalContainer = $('#modal-container');

            $(document).on("click", ".dt-print",
                function(e) {
                    e.preventDefault();

                    const id = $(this).data('id');

                    $.ajax({
                        url: `/sale/${id}`,
                        type: "GET",
                        success: function(res) {
                            modalCard.html(res);
                            modalContainer.removeClass('hidden').addClass('flex');
                            setTimeout(() => {
                                window.print();
                            }, 100);
                        }
                    });
                });

            $(window).on('click',
                function(e) {
                    if ($(e.target).is(modalContainer)) {
                        modalContainer.addClass('hidden').removeClass('flex');
                        modalCard.html('');
                    }
                });

            $(document).on('keydown',
                function(event) {
                    if (event.key === 'Escape' && modalContainer.hasClass('flex')) {
                        modalContainer.addClass('hidden').removeClass('flex');
                    }
                });
        });
    </script>
@endpush
