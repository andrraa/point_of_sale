@extends('layouts.app')

@section('title', 'Kasir')

@section('navTitle', 'Kasir POS')

@section('content')
    <div class="grid grid-cols-2 gap-4 items-start">
        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow">
            <div class="pb-2 mb-2 border-b border-b-gray-200">
                <h1 class="font-medium tracking-wider text-blue-900">Pelanggan & Barang</h1>
            </div>

            <div class="mb-2">
                <x-form.label :props="[
                    'for' => 'sales_customer_id',
                    'label' => 'Pelanggan',
                    'required' => true,
                ]" />
                <x-form.select :props="[
                    'id' => 'sales_customer_id',
                    'name' => 'sales_customer_id',
                    'class' => 'w-full',
                    'value' => null,
                ]" :options="$customers" />
            </div>

            <div class="mb-4">
                <x-form.label :props="[
                    'for' => 'sales_stock_id',
                    'label' => 'Barang',
                    'required' => true,
                ]" />
                <div class="flex gap-2">
                    <x-form.select :props="[
                        'id' => 'sales_stock_id',
                        'name' => 'sales_stock_id',
                        'class' => 'w-full',
                        'value' => null,
                    ]" :options="$stocks" />

                    <div class="w-1/5">
                        <x-form.input :props="[
                            'id' => 'sales_quantity',
                            'name' => 'sales_quantity',
                            'placeholder' => 'Jumlah (PCS)',
                            'value' => null,
                            'class' => 'number-input',
                        ]" />
                    </div>

                    <button type="button"
                        class="px-4 py-2 rounded-md border border-blue-900 text-blue-900 transition duration-200 w-1/5 font-medium tracking-wide cursor-pointer hover:bg-blue-900 hover:text-white active:scale-95">
                        <i class="fa-solid fa-basket-shopping me-1 text-sm"></i>
                        Keranjang
                    </button>
                </div>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow">
            <div class="pb-2 mb-4 border-b border-b-gray-200">
                <h1 class="font-medium tracking-wider text-blue-900">Keranjang Belanja</h1>
            </div>

            {{-- ITEM --}}
            <div class="stockGroup mt-2">
                @for ($i = 0; $i <= 4; $i++)
                    @include('cashier._item')
                @endfor
            </div>

            <div class="h-[1px] bg-gray-200 mt-6 mb-4"></div>

            {{-- DISKON & PAYMENT METHOD --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <x-form.label :props="[
                        'for' => 'sales_payment_type',
                        'label' => 'Metode Pembayaran',
                        'required' => true,
                    ]" />
                    <x-form.select :props="[
                        'id' => 'sales_payment_type',
                        'name' => 'sales_payment_type',
                        'class' => 'w-full',
                        'value' => null,
                    ]" :options="[
                        'cash' => 'Kontan',
                        'credit' => 'Tempo/Kredit',
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'sales_payment',
                        'label' => 'Jumlah Uang',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'id' => 'sales_payment',
                        'name' => 'sales_payment',
                        'class' => 'price-input',
                        'placeholder' => 'Masukkan Jumlah Uang',
                        'value' => null,
                    ]" />
                </div>

                <div>
                    <x-form.label :props="[
                        'for' => 'sales_discount',
                        'label' => 'Diskon (%)',
                        'required' => true,
                    ]" />
                    <x-form.input :props="[
                        'id' => 'sales_discount',
                        'name' => 'sales_discount',
                        'class' => 'number-input',
                        'value' => 0,
                    ]" />
                </div>
            </div>

            {{-- TOTAL --}}
            <div class="mt-6 rounded-lg border border-gray-300 p-4">
                <div class="flex items-center justify-between mb-1">
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Subtotal</h2>
                    </div>
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Rp 100.000</h2>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-1">
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Diskon</h2>
                    </div>
                    <div class="font-medium text-[15px] tracking-wide text-red-500">
                        <h2>Rp -0</h2>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Kembalian</h2>
                    </div>
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Rp 1.000</h2>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="font-bold tracking-wide text-blue-500 text-lg">
                        <h2>Total</h2>
                    </div>
                    <div class="font-bold tracking-wide text-blue-500 text-lg">
                        <h2>Rp 1.000</h2>
                    </div>
                </div>
            </div>

            {{-- CHECKOUT BUTTON --}}
            <div class="grid grid-cols-2 gap-4 mt-6">
                <button type="button"
                    class="px-4 py-2 w-full font-medium tracking-wide bg-blue-500 hover:bg-blue-600 rounded-md text-white transition duration-200 cursor-pointer active:scale-95">
                    Checkout & Struk
                </button>
                <button type="button"
                    class="px-4 py-2 w-full font-medium tracking-wide bg-red-500 hover:bg-red-600 rounded-md text-white transition duration-200 cursor-pointer active:scale-95">
                    Checkout
                </button>
            </div>
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

            $('.price-input').on('input',
                function() {
                    this.value = customFunction.formatNumberToRupiah(this.value.replace(/[^0-9]/g, ''));
                });
        });
    </script>
@endpush
