@extends('layouts.app')

@push('styles')
    @vite('resources/css/print.css')
@endpush

@section('title', 'Penjualan')

@section('navTitle', 'Daftar Penjualan')

@section('content')
    <div class="mb-4 flex items-center gap-2">
        <button type="button" id="open-report-modal"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white text-slate-700 text-sm font-medium tracking-wide border border-slate-300 hover:bg-slate-50 transition-all duration-200 shadow-sm cursor-pointer">
            <i class="fa-solid fa-file text-xs"></i>
            Laporan Penjualan
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
        <table id="sale-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Invoice</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Pelanggan</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Total Harga</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Total Hutang</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Tanggal</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Status</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tfoot class="!text-xs !tracking-wide !font-medium bg-slate-50">
                <tr>
                    <td colspan="3" class="p-2 !text-center text-slate-600">Total</td>
                    <td id="total_price" class="p-2 text-slate-700"></td>
                    <td id="total_debt" class="p-2 text-slate-700"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                    <td class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- MODAL PRINT --}}
    <div id="modal-container"
        class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full items-center justify-center hidden">
        <div id="modal-card" class="relative mx-auto p-4 border border-slate-300 w-[219px] shadow-lg rounded-lg bg-white">
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
                        class: 'font-bold !text-xs tracking-wider !text-slate-800'
                    },
                    {
                        data: 'customer.customer_name',
                        name: 'customer.customer_name',
                        class: 'tracking-wider !text-xs !text-slate-700',
                    },
                    {
                        data: 'sales_total_price',
                        name: 'sales_total_price',
                        class: 'tracking-wider !text-xs !text-slate-700',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'sale_total_debt',
                        name: 'sale_total_debt',
                        class: 'tracking-wider !text-xs !text-slate-700',
                        render: function(data) {
                            return 'Rp ' + customFunction.formatNumberToRupiah(data);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'tbl_sales.created_at',
                        class: 'tracking-wider !text-xs !text-slate-700',
                    },
                    {
                        data: 'sales_status',
                        name: 'sales_status',
                        class: 'tracking-wider !text-xs',
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
                                    `<span class="!text-xs text-emerald-600 font-medium">Status Kredit: ${creditStatus}</span>`;
                            }

                            const color = data == 0 ? 'text-red-500' : 'text-slate-700';

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
                    target: [0, 2, -1],
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
                            }, 300);
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
                $('#modal-sale-report').removeClass('hidden').addClass('flex');
            });

            $('.modal-report-cancel').on('click', function() {
                $('#modal-sale-report').removeClass('flex').addClass('hidden');
            });

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
