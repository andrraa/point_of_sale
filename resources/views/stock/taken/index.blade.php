@extends('layouts.app')

@section('title', 'Pengambilan Stok')

@section('navTitle', 'Daftar Pengambilan Stok')

@section('content')
    @php
        $today = \Carbon\Carbon::now()->toDateString();
    @endphp

    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('stock.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>

        <button id="open-taken-modal" type="button"
            class="px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium tracking-wide border border-slate-800 hover:bg-white hover:text-slate-800 transition-all duration-200 cursor-pointer shadow-sm">
            <i class="fa-solid fa-plus text-xs mr-2"></i>
            Pengambilan Stok
        </button>

        <button id="open-stock-modal" type="button"
            class="px-4 py-2 rounded-lg bg-amber-500 text-white text-sm font-medium tracking-wide border border-amber-500 hover:bg-white hover:text-amber-500 transition-all duration-200 cursor-pointer shadow-sm">
            <i class="fa-solid fa-file text-xs mr-2"></i>
            Laporan
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-4 p-5">
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
        <table id="stock-taken-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kode Stok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama Stok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kategori</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Jumlah</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Harga</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Tanggal</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Pengguna</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Deskripsi</th>
                </tr>
            </thead>
            <tfoot class="!text-xs !tracking-wide !font-medium">
                <tr class="bg-slate-50">
                    <td colspan="4" class="p-2 !text-center text-slate-600">Total</td>
                    <td id="total_stock_all" class="p-2 text-slate-700"></td>
                    <td colspan="4" id="total_stock_purchase_price" class="p-2 text-slate-700"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @include('stock.taken.modal')
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])

    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script type="module">
        {!! $validator !!}
        {!! $reportValidator !!}

        $(document).ready(function() {
            const dataTableAction = window.DataTablesAction;
            const customFunction = window.CustomFunction;

            let table = $('#stock-taken-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stock.taken') }}",
                    data: function(d) {
                        d.category_id = $('#filter').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock_taken_stock_code',
                        name: 'stock_taken_stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-slate-800'
                    },
                    {
                        data: 'stock_taken_stock_name',
                        name: 'stock_taken_stock_name',
                        class: 'tracking-wide !text-xs !text-slate-700 line-clamp-1'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'stock_taken_quantity',
                        name: 'stock_taken_quantity',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_taken_price',
                        name: 'stock_taken_price',
                        class: 'tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return `Rp ${data.toLocaleString()}`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                    },
                    {
                        data: 'user.full_name',
                        name: 'user.full_name',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                    },
                    {
                        data: 'stock_taken_description',
                        name: 'stock_taken_description',
                        class: 'tracking-wide !text-xs !text-slate-700 line-clamp-1',
                    },
                ],
                columnDefs: [{
                    target: [0, -1],
                    searchable: false,
                    orderable: false
                }],
                drawCallback: function(settings) {
                    const json = settings.json;

                    if (json) {
                        $('#total_stock_all').html(`${json.total_stock_all} pcs`);
                        $('#total_stock_purchase_price').html(
                            `Rp ${customFunction.formatNumberToRupiah(json.total_stock_purchase_price)}`
                        );
                    }
                }
            });

            $('#filter').on('change', function() {
                table.ajax.reload();
            });

            $('#open-taken-modal').on('click', function() {
                openModal('#modal-taken');
            });

            $('.taken-cancel').on('click', function() {
                closeModal('#modal-taken');
            });

            $('#open-stock-modal').on('click', function() {
                openModal('#modal-taken-report');
            });

            $('.taken-report-cancel').on('click', function() {
                closeModal('#modal-taken-report');
            });

            function openModal(selector) {
                $(selector).removeClass('hidden').addClass('flex');
            }

            function closeModal(selector) {
                $(selector).removeClass('flex').addClass('hidden');
            }
        });
    </script>
@endpush
