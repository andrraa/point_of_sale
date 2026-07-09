@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Ubah Penjualan / Return Barang')

@section('content')
    <div class="mb-4 w-fit">
        <a href="{{ route('sale.index') }}"
            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors duration-200 text-slate-600">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <table class="table w-full">
            <thead class="!text-xs !tracking-wide !text-left bg-slate-50 font-semibold text-slate-600">
                <tr>
                    <th class="p-2">No.</th>
                    <th class="p-2">Nama Barang</th>
                    <th class="p-2">Harga Jual</th>
                    <th class="p-2 w-[300px]">Jumlah Jual</th>
                    <th class="p-2 w-[150px]">Aksi</th>
                </tr>
            </thead>
            @php
                $totalPrice = 0;
                $totalQuantity = 0;
            @endphp
            <tbody class="!text-xs !tracking-wide divide-y divide-slate-100">
                @foreach ($sale->details as $index => $detail)
                    <tr>
                        <td class="p-2 text-slate-700">{{ $index + 1 }}</td>
                        <td class="p-2 text-slate-700">
                            {{ $detail->sale_detail_stock_code . ' - ' . $detail->sale_detail_stock_name }}
                        </td>
                        <td class="p-2 text-slate-700">Rp {{ number_format($detail->sale_detail_price) }}</td>
                        <td class="p-2">
                            <x-form.input :props="[
                                'id' => 'quantity-' . $detail->sale_detail_id,
                                'name' => 'quantity-' . $detail->sale_detail_id,
                                'value' => $detail->sale_detail_quantity,
                                'class' => 'number-input',
                            ]" />
                        </td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <button type="button" data-id="{{ $detail->sale_detail_id }}"
                                    data-url="{{ route('sale-detail.update', $detail->sale_detail_id) }}"
                                    class="btn-save px-2 py-1 border border-slate-300 rounded cursor-pointer text-slate-800 hover:bg-slate-100 transition-colors text-xs">
                                    <i class="fa-solid fa-save"></i>
                                </button>

                                <button type="button" data-id="{{ $detail->sale_detail_id }}"
                                    data-url="{{ route('sale-detail.destroy', $detail->sale_detail_id) }}"
                                    class="btn-delete px-2 py-1 border border-slate-300 rounded cursor-pointer text-red-500 hover:bg-slate-100 transition-colors text-xs">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @php
                        $totalPrice += $detail->sale_detail_quantity * $detail->sale_detail_price;
                        $totalQuantity += $detail->sale_detail_quantity;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-50">
                    <td class="p-2 text-xs font-medium text-slate-600"></td>
                    <td class="p-2 text-xs font-medium text-slate-600">Total:</td>
                    <td class="p-2 text-xs font-medium text-slate-700">Rp {{ number_format($totalPrice) }}</td>
                    <td class="p-2 text-xs font-medium text-slate-700">{{ $totalQuantity }} pcs</td>
                    <td class="p-2 text-xs font-medium text-slate-600"></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')

    <script type="module">
        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });

            // UPDATE
            $('.btn-save').on('click', function() {
                const id = $(this).data('id');
                const url = $(this).data('url');
                const quantity = $(`#quantity-${id}`).val();

                if (quantity < 1 || !quantity) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Quantity minimal adalah 1',
                        icon: 'error'
                    });

                    return;
                }

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Silakan tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        quantity: quantity
                    },
                    success: function(res) {
                        if (res) {
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengubah data penjualan.'
                            });
                        }
                    }
                });
            });

            // DELETE
            $('.btn-delete').on('click', function() {
                const url = $(this).data('url');

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Silakan tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(res) {
                        if (res) {
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengubah data penjualan.'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
