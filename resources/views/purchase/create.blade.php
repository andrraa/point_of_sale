@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Pembelian Baru')

@section('content')
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form id="form-create-purchase" action="{{ route('purchase.store') }}" method="POST">
            @csrf

            @include('purchase._form')

            <div class="pb-10 pt-4">
                <table class="w-full">
                    <thead class="text-left text-sm bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <td class="p-2 tracking-wide text-xs">Kode Barang</td>
                            <td class="p-2 tracking-wide text-xs">Nama Barang</td>
                            <td class="p-2 tracking-wide text-xs">Harga Pokok</td>
                            <td class="p-2 tracking-wide text-xs">Jumlah</td>
                            <td class="p-2 tracking-wide text-xs">Total Harga</td>
                            <td class="p-2 tracking-wide text-xs">Aksi</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <x-form.action :props="[
                'url' => route('purchase.index'),
            ]" />
        </form>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')
    <script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script type="module">
        {!! $validator !!}
    </script>
    <script type="module">
        $(document).ready(function() {
            $('#item').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#item-button').click();
                }
            });

            const customFunction = window.CustomFunction;

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });

            $('#item-button').on('click', function(e) {
                e.preventDefault();

                const item = $('#item').val().trim();
                const quantity = $('#quantity').val();

                if (item === '') {
                    alert('Masukkan kode atau nama barang!');
                    return;
                }

                if (!isNaN(item)) {
                    addItemByCode(item, quantity);
                    return;
                }

                searchItemByName(item);
            });

            $(document).on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });

            function searchItemByName(keyword) {
                $.ajax({
                    url: "{{ route('purchase.search.item') }}",
                    type: "POST",
                    data: { q: keyword },
                    success: function(res) {
                        if (!res.data.length) {
                            Swal.fire({
                                title: 'Tidak ditemukan',
                                text: 'Nama barang tidak cocok',
                                icon: 'warning',
                                timer: 1000
                            });
                            return;
                        }

                        let html = '<div class="text-left max-h-72 overflow-y-auto">';
                        res.data.forEach(item => {
                            html += `
                                <div class="p-2 border-b hover:bg-slate-100 cursor-pointer select-item"
                                    data-id="${item.stock_id}"
                                    data-name="${item.stock_name}"
                                    data-code="${item.stock_code}"
                                    data-price="${item.stock_purchase_price}"
                                >
                                    <b>${item.stock_code}</b> - ${item.stock_name}
                                </div>`;
                        });
                        html += '</div>';

                        Swal.fire({
                            title: 'Pilih Barang',
                            html: html,
                            showConfirmButton: false,
                            width: 600,
                        });

                        $('.select-item').on('click', function() {
                            const itemCode = $(this).data('code');
                            const quantity = $('#quantity').val() || 1;

                            Swal.close();
                            addItemByCode(itemCode, quantity);
                        });
                    }
                });
            }

            function addItemByCode(item, quantity) {
                if (quantity < 1 || quantity === '' || quantity === null) {
                    alert('Masukkan Jumlah Yang Valid!');
                    return;
                }

                const index = $('table tbody tr').length;

                $.ajax({
                    url: "{{ route('purchase.get.item') }}",
                    method: 'POST',
                    data: {
                        item: item,
                        quantity: quantity,
                        index: index
                    },
                    success: function(response) {
                        if (!response) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Produk tidak ditemukan',
                                icon: 'error',
                                timer: 1000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        } else {
                            $('#item').val('');
                            $('#quantity').val(1);
                            $('table tbody').append(response);
                        }
                    },
                });
            }
        });
    </script>
@endpush
