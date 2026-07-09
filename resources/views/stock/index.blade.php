@extends('layouts.app')

@section('title', 'Stok Barang')

@section('navTitle', 'Daftar Stok')

@section('content')
    <div class="mb-4 flex items-center gap-2">
        <x-action-button :props="[
            'url' => route('stock.create'),
            'label' => 'Stok Baru',
        ]" />

        <a href="{{ route('stock.taken') }}"
            class="px-4 py-2 rounded-lg bg-amber-500 text-white text-sm font-medium tracking-wide border border-amber-500 hover:bg-white hover:text-amber-500 transition-all duration-200 shadow-sm">
            <i class="fa-solid fa-plus-minus text-xs mr-2"></i>
            Pengambilan Stok
        </a>

        <button type="button" id="open-stock-modal"
            class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium tracking-wide border border-emerald-600 hover:bg-white hover:text-emerald-600 transition-all duration-200 cursor-pointer shadow-sm">
            <i class="fa-solid fa-file text-xs mr-2"></i>
            Laporan Stok
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-4 p-5 flex items-center gap-4">
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

        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filterRack',
                'label' => 'Filter Rak',
                'required' => true,
                'class' => 'text-slate-700 font-medium text-sm',
            ]" />

            <x-form.select :props="[
                'id' => 'filterRack',
                'name' => 'filterRack',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$racks" />
        </div>

        <div class="w-1/3">
            <x-form.label :props="[
                'for' => 'filterSS',
                'label' => 'Filter Supplier',
                'required' => true,
                'class' => 'text-slate-700 font-medium text-sm',
            ]" />

            <x-form.select :props="[
                'id' => 'filterSS',
                'name' => 'filterSS',
                'value' => null,
                'class' => 'w-full',
            ]" :options="$suppliers" />
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <table id="stock-table" class="w-full">
            <thead class="!text-xs tracking-wide text-left">
                <tr>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">#</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kode</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Nama Stok</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Kategori</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Supplier</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Rak</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Stok Awal</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Stok Keluar</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Stok Akhir</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Harga Beli</th>
                    <th class="p-3 bg-slate-50 text-slate-600 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tfoot class="!text-xs !tracking-wide !font-medium">
                <tr class="bg-slate-50">
                    <td colspan="6" class="p-2 !text-center text-slate-600">Total</td>
                    <td id="total_stock_awal" class="p-2 text-slate-700"></td>
                    <td id="total_stock_out" class="p-2 text-slate-700"></td>
                    <td id="total_stock_all" class="p-2 text-slate-700"></td>
                    <td colspan="2" id="total_stock_purchase_price" class="p-2 text-slate-700"></td>
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
                        d.category_id = $('#filter').val(),
                        d.rack_id = $('#filterRack').val(),
                        d.ss_id = $('#filterSS').val();
                    }
                },
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'stock_code',
                        name: 'stock_code',
                        class: 'font-bold tracking-wide !text-xs !text-slate-800'
                    },
                    {
                        data: 'stock_name',
                        name: 'stock_name',
                        class: 'tracking-wide !text-xs !text-slate-700 line-clamp-1'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        class: 'tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'supplier_stock.ss_name',
                        name: 'supplier_stock.ss_name',
                        class: 'tracking-wide !text-xs !text-slate-700 line-clamp-1'
                    },
                    {
                        data: 'rack.category_name',
                        name: 'rack.category_name',
                        class: 'tracking-wide !text-xs !text-slate-700'
                    },
                    {
                        data: 'stock_awal',
                        name: 'stock_awal',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_total',
                        name: 'stock_total',
                        class: 'font-medium tracking-wide !text-xs !text-slate-700',
                        render: function(data) {
                            return `${data} pcs`;
                        }
                    },
                    {
                        data: 'stock_purchase_price',
                        name: 'stock_purchase_price',
                        class: 'font-medium tracking-wide !text-xs !text-emerald-600',
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
                    target: [0, -1, 4, 6],
                    searchable: false,
                    orderable: false
                }],
                drawCallback: function(settings) {
                    const json = settings.json;

                    if (json) {
                        const price = json.total_stock_purchase_price ?? 0;

                        $('#total_stock_awal').html(`${json.total_stock_awal} pcs`);
                        $('#total_stock_out').html(`${json.total_stock_out} pcs`);
                        $('#total_stock_all').html(`${json.total_stock_all} pcs`);
                        $('#total_stock_purchase_price').html(
                            `Rp ${customFunction.formatNumberToRupiah(price)}`);
                    }
                }
            });

            $('#filter').on('change', function() {
                table.ajax.reload();
            });

            $('#filterRack').on('change', function() {
                table.ajax.reload();
            });

            $('#filterSS').on('change', function() {
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
