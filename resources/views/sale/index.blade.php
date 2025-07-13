@extends('layouts.app')

@push('styles')
    <style>
        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

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
                width: 58mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
                display: block !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
                overflow: hidden;
                page-break-inside: avoid;
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
    <div class="mb-4 flex items-center gap-2">
        <button type="button" id="open-report-modal"
            class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-medium tracking-wide border border-transparent hover:bg-white hover:border-red-500 hover:text-red-500 transition-all duration-300 cursor-pointer shadow-lg">
            <i class="fa-solid fa-file text-xs mr-2"></i>
            Laporan Penjualan
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-4 p-4">
        <div class="w-full">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Tanggal',
                'required' => true,
            ]" />

            <div class="flex items-center gap-4 pb-3">
                @php
                    $today = \Carbon\Carbon::now()->toDateString();
                @endphp

                <input type="date" id="start_date" name="start_date"
                    class="px-4 py-2 w-full rounded-lg border border-gray-300 outline-none" value="{{ $today }}">

                <input type="date" id="end_date" name="end_date"
                    class="px-4 py-2 w-full rounded-lg border border-gray-300 outline-none" value="{{ $today }}">
            </div>

            <button id="filter-button"
                class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg tracking-wide font-medium hover:bg-blue-600 transition-colors duration-300 cursor-pointer shadow-lg">
                <i class="fa-solid fa-magnifying-glass text-xs mr-1"></i>
                Cari Data
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="sale-table" class="w-full min-w-max">
            <thead class="!text-[13px] tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100 w-[10px]">#</th>
                    <th class="p-3 bg-gray-100 w-[100px]">Invoice</th>
                    <th class="p-3 bg-gray-100 w-[200px]">Pelanggan</th>
                    <th class="p-3 bg-gray-100 w-[150px]">Total Harga</th>
                    <th class="p-3 bg-gray-100 w-[150px]">Total Hutang</th>
                    <th class="p-3 bg-gray-100 w-[150px]">Tanggal Penjualan</th>
                    <th class="p-3 bg-gray-100 w-[150px]">Status</th>
                    <th class="p-3 bg-gray-100 w-[150px]">Aksi</th>
                </tr>
            </thead>
            <tfoot class="!text-[13px] !tracking-wide !font-medium bg-gray-100">
                <tr>
                    <td colspan="3" class="p-2 !text-center">Total</td>
                    <td id="total_price" class="p-2"></td>
                    <td id="total_debt" class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL --}}
    <div id="modal-container"
        class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full items-center justify-center hidden">
        <div id="modal-card"
            class="relative mx-auto p-4 border border-gray-300 w-full max-w-[400px] shadow-lg rounded-lg bg-white">
        </div>
    </div>

    {{-- MODAL REPORT --}}
    @include('sale.modal')
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script type="module">
        {!! $validator !!}

        $(document).ready(function() {
            const dataTable = window.DataTables;
            const dataTableAction = window.DataTablesAction;
            const dataTableSelector = "#sale-table";

            const customFunction = window.CustomFunction;

            let table = $(dataTableSelector).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sale.index') }}",
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
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }],
                drawCallback: function(settings) {
                    const json = settings.json;
                    const price = json.total_price;
                    const debt = json.total_debt;

                    if (json) {
                        $('#total_price').html(`Rp ${customFunction.formatNumberToRupiah(price)}`);
                        $('#total_debt').html(`Rp ${customFunction.formatNumberToRupiah(debt)}`);
                    }
                }
            });

            $('#filter-button').on('click', function() {
                table.ajax.reload();
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

            // Report Modal
            $('#open-report-modal').on('click', function() {
                openModal();
            });

            $('.modal-report-cancel').on('click', function() {
                closeModal();
            });

            function openModal() {
                $('#modal-sale-report').removeClass('hidden').addClass('flex');
            }

            function closeModal() {
                $('#modal-sale-report').removeClass('flex').addClass('hidden');
            }

            $(document).on('click', '#cancel-print-button', function() {
                $('#modal-container').addClass('hidden').removeClass('flex');
                $('#modal-card').html('');
            });

            $(document).on('click', '#print-button', function() {
                window.print();
            });
        });
    </script>
@endpush
