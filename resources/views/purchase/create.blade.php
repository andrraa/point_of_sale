@extends('layouts.app')

@section('title', 'Pembelian')

@section('navTitle', 'Pembelian Baru')

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <form id="form-create-purchase" action="{{ route('purchase.store') }}" method="POST">
            @csrf

            @include('purchase._form')

            <div class="pb-10 pt-2">
                <table class="w-full">
                    <thead class="text-left text-sm bg-gray-100 font-medium">
                        <tr>
                            <td class="p-2 tracking-wide">Kode Barang</td>
                            <td class="p-2 tracking-wide">Nama Barang</td>
                            <td class="p-2 tracking-wide">Harga Pokok</td>
                            <td class="p-2 tracking-wide">Jumlah</td>
                            <td class="p-2 tracking-wide">Total Harga</td>
                            <td class="p-2 tracking-wide">Aksi</td>
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
            const customFunction = window.CustomFunction;

            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });

            $('#item-button').on('click', function(e) {
                e.preventDefault();

                const item = $('#item').val();
                const quantity = $('#quantity').val();

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
                        $('#quantity').val('');
                        $('table tbody').append(response);
                    },
                });
            });

            $(document).on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
