@extends('layouts.app')

@section('title', 'Stok Barang')

@section('navTitle', 'Daftar Stok')

@section('content')
    <div class="mb-4 flex items-center gap-2">
        <x-action-button :props="[
            'url' => route('stock.create'),
            'label' => 'Stok Baru',
        ]" />

        <a href="{{ route('stock.taken') }}">
            <div
                class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-medium tracking-wide hover:bg-white border border-transparent hover:border-red-500 hover:text-red-500 transition-all duration-300 shadow-lg">
                <i class="fa-solid fa-plus-minus text-xs mr-2"></i>
                Ambil Stok
            </div>
        </a>

        <button type="button" id="open-stock-modal"
            class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium tracking-wide border border-transparent hover:bg-white hover:border-green-600 hover:text-green-600 transition-all duration-300 cursor-pointer shadow-lg">
            <i class="fa-solid fa-file text-xs mr-2"></i>
            Laporan Stok
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
        <table id="stock-table" class="w-full min-w-max">
            <thead class="!text-[13px] !tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-gray-100">#</th>
                    <th class="p-3 bg-gray-100">Kode Stok</th>
                    <th class="p-3 bg-gray-100">Nama Stok</th>
                    <th class="p-3 bg-gray-100">Kategori</th>
                    <th class="p-3 bg-gray-100">Total Stok</th>
                    <th class="p-3 bg-gray-100">Stok Keluar</th>
                    <th class="p-3 bg-gray-100">Harga Beli</th>
                    <th class="p-3 bg-gray-100">Aksi</th>
                </tr>
            </thead>
            <tfoot class="!text-[13px] !tracking-wide !font-medium bg-gray-100">
                <tr>
                    <td colspan="4" class="p-2 !text-center">Total</td>
                    <td id="total_stock_all" class="p-2"></td>
                    <td id="total_stock_out" class="p-2"></td>
                    <td colspan="2" id="total_stock_purchase_price" class="p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @include('stock.modal')
@endsection

@push('scripts')
    @vite(['resources/js/datatables.js', 'resources/js/function.js'])

    <script type="module">
        $(document).ready(function() {
            const dataTableAction = window.DataTablesAction;
            const customFunction = window.CustomFunction;

            let table = $('#stock-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stock.index') }}",
                    data: function(d) {
                        d.category_id = $('#filter').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock_code',
                        name: 'stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-blue-500'
                    },
                    {
                        data: 'stock_name',
                        name: 'stock_name',
                        class: 'tracking-wide !text-xs !text-gray-900 line-clamp-1'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wide !text-xs !text-gray-900'
                    },
                    {
                        data: 'stock_total',
                        name: 'stock_total',
                        class: 'font-medium tracking-wide !text-xs !text-gray-900',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out',
                        class: 'font-medium tracking-wide !text-xs !text-red-500',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_purchase_price',
                        name: 'stock_purchase_price',
                        class: 'font-medium tracking-wide !text-xs !text-green-500',
                        render: function(data) {
                            return `Rp ${customFunction.formatNumberToRupiah(data)}`;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        render: function(data) {
                            return dataTableAction(data, '#stock-table');
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
        });
    </script>
@endpush
