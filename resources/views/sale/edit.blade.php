@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Ubah Penjualan / Return Barang')

@section('content')
    <div class="mb-6 mt-2">
        <a href="{{ route('sale.index') }}"
            class="px-4 py-2 rounded-md border border-gray-500 text-sm transition-colors duration-300 hover:bg-gray-200 tracking-wide text-gray-500">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg p-6 border border-gray-200">
        <table class="table w-full">
            <thead class="!text-[13px] !tracking-wide !text-left bg-gray-100">
                <tr>
                    <th class="p-3">No.</th>
                    <th class="p-3">Nama Barang</th>
                    <th class="p-3">Harga Jual</th>
                    <th class="p-3 w-[300px]">Jumlah Jual</th>
                    <th class="p-3 w-[150px]">Aksi</th>
                </tr>
            </thead>
            @php
                $totalPrice = 0;
                $totalQuantity = 0;
            @endphp
            <tbody class="!text-[13px] !tracking-wide divide-y divide-gray-100">
                @foreach ($sale->details as $index => $detail)
                    <tr>
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">
                            {{ $detail->sale_detail_stock_code . ' - ' . $detail->sale_detail_stock_name }}
                        </td>
                        <td class="p-3">Rp {{ number_format($detail->sale_detail_price) }}</td>
                        <td class="p-3">
                            <x-form.input :props="[
                                'id' => 'quantity-' . $detail->sale_detail_id,
                                'name' => 'quantity-' . $detail->sale_detail_id,
                                'value' => $detail->sale_detail_quantity,
                                'class' => 'number-input',
                            ]" />
                        </td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <button type="button" data-id="{{ $detail->sale_detail_id }}"
                                    data-url="{{ route('sale-detail.update', $detail->sale_detail_id) }}"
                                    class="btn-save px-2 py-1 border rounded-sm cursor-pointer text-blue-500">
                                    <i class="fa-solid fa-save"></i>
                                </button>

                                <button type="button" data-id="{{ $detail->sale_detail_id }}"
                                    data-url="{{ route('sale-detail.destroy', $detail->sale_detail_id) }}"
                                    class="btn-delete px-2 py-1 border rounded-sm cursor-pointer text-red-500">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @php
                        $totalPrice = $detail->sale_detail_quantity * $detail->sale_detail_price;
                        $totalQuantity += $detail->sale_detail_quantity;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="p-3 bg-gray-100 text-[13px] font-medium"></td>
                    <td class="p-3 bg-gray-100 text-[13px] font-medium">
                        Total:
                    </td>
                    <td class="p-3 bg-gray-100 text-[13px] font-medium">
                        Rp {{ number_format($totalPrice) }}
                    </td>
                    <td class="p-3 bg-gray-100 text-[13px] font-medium">
                        {{ $totalQuantity }} pcs
                    </td>
                    <td class="p-3 bg-gray-100 text-[13px] font-medium"></td>
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
