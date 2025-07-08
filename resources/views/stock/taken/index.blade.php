@extends('layouts.app')

@section('title', 'Stok Barang Diambil')

@section('navTitle', 'Daftar Stok Diambil')

@section('content')
    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('stock.index') }}">
            <div class="flex items-center gap-2 px-4 py-2 rounded-md border text-sm border-gray-400">
                <i class="fa-solid fa-chevron-left text-xs"></i>
                <span>Kembali</span>
            </div>
        </a>

        <button id="open-taken-modal" type="button"
            class="px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-medium tracking-wide border border-transparent hover:bg-white hover:border-blue-500 hover:text-blue-500 transition-all duration-300 cursor-pointer">
            <i class="fa-solid fa-plus text-xs mr-2"></i>
            Ambil Stock
        </button>

        <button id="open-stock-modal" type="button"
            class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-medium tracking-wide border border-transparent hover:bg-white hover:border-red-500 hover:text-red-500 transition-all duration-300 cursor-pointer">
            <i class="fa-solid fa-file text-xs mr-2"></i>
            Laporan Stok Diambil
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-4 p-4">
        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filter',
                'label' => 'Filter Kategori',
                'required' => true,
            ]" />

            <x-form.select :props="[
                'id' => 'filter',
                'name' => 'filter',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$categories" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 border border-gray-200 overflow-x-auto">
        <table id="stock-taken-table" class="w-full min-w-max">
            <thead class="!text-[13px] !tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100 w-[50px]">#</th>
                    <th class="p-3 bg-gray-100 w-[100px]">Kode Stok</th>
                    <th class="p-3 bg-gray-100">Nama Stok</th>
                    <th class="p-3 bg-gray-100 w-[50px]">Jumlah</th>
                    <th class="p-3 bg-gray-100 w-[120px]">Harga</th>
                    <th class="p-3 bg-gray-100 w-[120px]">Tanggal</th>
                    <th class="p-3 bg-gray-100 w-[100px]">Pengguna</th>
                    <th class="p-3 bg-gray-100">Deskripsi</th>
                </tr>
            </thead>
            <tfoot class="!text-[13px] !tracking-wide !font-medium bg-gray-100">
                <tr>
                    <td colspan="3" class="p-2 !text-center">Total</td>
                    <td id="total_stock_all" class="p-2"></td>
                    <td colspan="4" id="total_stock_purchase_price" class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Taken Modal --}}
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
                        class: 'font-bold tracking-wide !text-xs !text-blue-500'
                    },
                    {
                        data: 'stock_taken_stock_name',
                        name: 'stock_taken_stock_name',
                        class: 'tracking-wide !text-xs !text-gray-900 line-clamp-1'
                    },
                    {
                        data: 'stock_taken_quantity',
                        name: 'stock_taken_quantity',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_taken_price',
                        name: 'stock_taken_price',
                        class: 'tracking-wide !text-xs !text-gray-900',
                        render: function(data) {
                            return `Rp ${data.toLocaleString()}`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        class: 'font-medium tracking-wide !text-xs !text-green-500',
                    },
                    {
                        data: 'user.full_name',
                        name: 'user.full_name',
                        class: 'font-medium tracking-wide !text-xs !text-green-500',
                    },
                    {
                        data: 'stock_taken_description',
                        name: 'stock_taken_description',
                        class: 'tracking-wide !text-xs !text-gray-900 truncate max-w-[150px]'
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
                        const price = json.total_stock_purchase_price;

                        $('#total_stock_all').html(`${json.total_stock_all} pcs`);
                        $('#total_stock_out').html(`${json.total_stock_out} pcs`);
                        $('#total_stock_purchase_price').html(
                            `Rp ${customFunction.formatNumberToRupiah(price)}`);
                    }
                }
            });

            $('#filter').on('change', function() {
                table.ajax.reload();
            });

            // TakenModal
            $('#open-taken-modal').on('click', function() {
                openModal('#modal-stock-taken');
            });

            $('.modal-taken-cancel').on('click', function() {
                closeModal('#modal-stock-taken');
            });

            $('#open-stock-modal').on('click', function() {
                openModal('#modal-stock-report');
            });

            $('.modal-stock-cancel').on('click', function() {
                closeModal('#modal-stock-report');
            });

            function openModal(selector) {
                $(selector).removeClass('hidden').addClass('flex');
            }

            function closeModal(selector) {
                $(selector).removeClass('flex').addClass('hidden');
            }

            // Report Modal
        });
    </script>
@endpush
