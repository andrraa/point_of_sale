@extends('layouts.app')

@section('title', 'Penjualan')

@section('navTitle', 'Ubah Penjualan / Return Barang')

@section('content')
    <div class="bg-white rounded-lg p-8 border border-gray-200">
        <div class="mb-6">
            <table class="table w-full">
                <thead class="!text-[13px] !tracking-wide !text-left bg-gray-100">
                    <tr>
                        <th class="p-3">No.</th>
                        <th class="p-3">Nama Barang</th>
                        <th class="p-3">Harga Beli</th>
                        <th class="p-3 w-[300px]">Jumlah Beli</th>
                        <th class="p-3 w-[150px]">Aksi</th>
                    </tr>
                </thead>
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
                                        class="btn-save px-2 py-1 border rounded-sm cursor-pointer text-blue-500">
                                        <i class="fa-solid fa-save"></i>
                                    </button>

                                    <button type="button" data-id="{{ $detail->sale_detail_id }}"
                                        class="btn-delete px-2 py-1 border rounded-sm cursor-pointer text-red-500">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
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
                const quantity = $(`#quantity-${id}`).val();

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Silakan tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            // DELETE
            $('.btn-delete').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Silakan tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>
@endpush
