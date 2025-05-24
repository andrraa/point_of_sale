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
                <x-form.select :props="[
                    'id' => 'sales_stock_id',
                    'name' => 'sales_stock_id',
                    'class' => 'w-full',
                    'value' => null,
                ]" :options="$stocks" />
            </div>
            <div class="flex gap-2">
                <x-form.input :props="[
                    'id' => 'sales_quantity',
                    'name' => 'sales_quantity',
                    'placeholder' => 'Jumlah (PCS)',
                    'value' => null,
                    'class' => 'number-input',
                ]" />

                <button type="button" id="chart-button"
                    class=" rounded-md border border-blue-900 text-blue-900 transition duration-200 font-medium tracking-wide cursor-pointer hover:bg-blue-900 hover:text-white active:scale-95 px-4">
                    Keranjang
                </button>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow">
            <div class="pb-2 mb-4 border-b border-b-gray-200">
                <h1 class="font-medium tracking-wider text-blue-900">Keranjang Belanja</h1>
            </div>

            {{-- ITEM --}}
            <div class="stockGroup mt-2">
                <div class="rounded-md border border-gray-200 text-center py-4 italic text-sm tracking-wider text-gray-500">
                    Keranjang Kosong.
                </div>
            </div>

            <div class="h-[1px] bg-gray-200 mt-6 mb-4"></div>

            {{-- DISKON & PAYMENT METHOD --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <x-form.label :props="[
                        'for' => 'sales_payment_type',
                        'label' => 'Jenis Pembayaran',
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
                        'placeholder' => 'Jumlah Uang',
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

            {{-- SUMMARY --}}
            <div class="mt-6 mb-4 rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Subtotal</h2>
                    </div>
                    <div class="summary-subtotal font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Rp 0</h2>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <div class="font-medium text-[15px] tracking-wide text-gray-900">
                        <h2>Diskon</h2>
                    </div>
                    <div class="summary-discount font-medium text-[15px] tracking-wide text-red-500">
                        <h2>Rp 0</h2>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <div class="font-bold tracking-wide text-blue-500 text-lg">
                        <h2>Total</h2>
                    </div>
                    <div class="summary-total font-bold tracking-wide text-blue-500 text-lg">
                        <h2>Rp 0</h2>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-1">
                    <div class="font-bold tracking-wide text-green-700 text-lg">
                        <h2>Kembalian</h2>
                    </div>
                    <div class="summary-change font-bold tracking-wide text-green-700 text-lg">
                        <h2>Rp 0</h2>
                    </div>
                </div>
            </div>

            {{-- CHECKOUT BUTTON --}}
            <button type="button" id="checkout-button"
                class="px-4 py-2 w-full font-medium tracking-wide bg-blue-900 hover:bg-blue-950 rounded-md text-white transition duration-200 cursor-pointer active:scale-95">
                Proses Pembayaran
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/function.js')
    <script type="module">
        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            // Number Input & Price Input
            $('.number-input').on('input',
                function() {
                    this.value = customFunction.numberOnly(this.value);
                });

            $('.price-input').on('input',
                function() {
                    this.value = customFunction.formatNumberToRupiah(this.value.replace(/[^0-9]/g, ''));
                });

            // Customer
            $('#sales_customer_id').on('change',
                function() {
                    resetCartItems();
                });

            // CHART
            let cartItems = [];

            $('#chart-button').on('click',
                function() {
                    const customerId = $('#sales_customer_id').val();
                    const stockId = $('#sales_stock_id').val();
                    const quantity = $('#sales_quantity').val();

                    $.ajax({
                        url: "{{ route('cashier.get-item') }}",
                        type: "POST",
                        data: {
                            customerId: customerId,
                            stockId: stockId,
                            quantity: quantity
                        },
                        success: function(response) {
                            if (response.success) {
                                const item = {
                                    stockId: response.data.stockId,
                                    stockName: response.data.stockName,
                                    price: response.data.price,
                                    quantity: parseInt(response.data.quantity),
                                    maxQuantity: parseInt(response.data.maxQuantity)
                                };

                                const existingIndex = cartItems.findIndex(i => i.stockId === item
                                    .stockId);

                                if (existingIndex !== -1) {
                                    const currentQuantity = cartItems[existingIndex].quantity;
                                    const newQuantity = currentQuantity + item.quantity;

                                    if (newQuantity > item.maxQuantity) {
                                        cartItems[existingIndex].quantity = item.maxQuantity;

                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Melebihi Stok',
                                            text: `Jumlah maksimal stok ${item.stockName} adalah ${item.maxQuantity}`
                                        });
                                    } else {
                                        cartItems[existingIndex].quantity = newQuantity;
                                    }
                                } else {
                                    if (item.quantity > item.maxQuantity) {
                                        item.quantity = item.maxQuantity;

                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Melebihi Stok',
                                            text: `Jumlah maksimal stok ${item.stockName} adalah ${item.maxQuantity}`
                                        });
                                    }

                                    cartItems.push(item);
                                }

                                $('#sales_quantity').val('');
                                renderCartItems();
                            } else if (!response.success) {
                                Swal.fire('Error', response.message, 'error');
                            }
                        }
                    });
                });

            // CHECKOUT
            $('#checkout-button').on('click',
                function() {
                    const customerId = $('#sales_customer_id').val();
                    const paymentType = $('#sales_payment_type').val();
                    const totalPayment = $('#sales_payment').val();
                    const discount = $('#sales_discount').val();
                    const items = cartItems;

                    let totalPrice = 0;
                    cartItems.forEach(item => {
                        totalPrice += item.price * item.quantity
                    });

                    if ((totalPayment < totalPrice) && customerId == 1) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Jumlah bayar kurang dari total bayar (Sisa bayar Pelanggan Umum tidak bisa secara Credit/Tempo)',
                            icon: 'error'
                        });
                        return;
                    }

                    console.log(customerId);
                    console.log(paymentType);
                    console.log(totalPayment);
                    console.log(discount);
                    console.log(items);
                });

            $('#sales_payment_type').on('change',
                function() {
                    const customerId = $('#sales_customer_id').val();
                    const paymentType = $(this).val();

                    if (customerId == 1 && paymentType == 'credit') {
                        if (customerId == 1 && paymentType == 'credit') {
                            const select = $(this);
                            setTimeout(() => {
                                select.val('cash').trigger('change');
                                Swal.fire('Error',
                                    'Pelanggan Umum tidak bisa membayar dengan Credit/Tempo',
                                    'error');
                            }, 10);
                        }
                    }
                });

            $(document).on('input', '.quantity-input',
                function() {
                    const index = $(this).closest('.stockItem').data('index');
                    let newQuantity = parseInt($(this).val()) || 1;
                    const maxQuantity = cartItems[index].maxQuantity;

                    if (newQuantity > maxQuantity) {
                        newQuantity = maxQuantity;
                        $(this).val(maxQuantity);

                        Swal.fire({
                            icon: 'warning',
                            title: 'Jumlah Melebihi Stok!',
                            text: `Jumlah maksimal stok adalah ${maxQuantity}`
                        });
                    }

                    cartItems[index].quantity = newQuantity;
                    calculateSummary();
                });

            $('#sales_discount, #sales_payment').on('input',
                function() {
                    calculateSummary();
                });

            $(document).on('click', '.delete-item',
                function() {
                    const index = $(this).closest('.stockItem').data('index');
                    cartItems.splice(index, 1);
                    renderCartItems();
                });

            function calculateSummary() {
                let subTotal = 0;

                cartItems.forEach(item => {
                    subTotal += item.price * item.quantity;
                });

                const discountPercent = parseFloat($('#sales_discount').val()) || 0;
                const rawPaymentAmount = $('#sales_payment').val().replace(/\D/g, '');
                const paymentAmount = parseFloat(rawPaymentAmount) || 0;

                const discount = (discountPercent / 100) * subTotal;
                const total = subTotal - discount;
                const change = paymentAmount - total;

                $('.summary-subtotal').text('Rp ' + (customFunction.formatNumberToRupiah(subTotal) || '0'));
                $('.summary-discount').text('Rp ' + (customFunction.formatNumberToRupiah(discount) || '0'));
                $('.summary-total').text('Rp ' + (customFunction.formatNumberToRupiah(total) || '0'));

                const changeFormatted = customFunction.formatNumberToRupiah(change) || '0';
                const changeElement = $('.summary-change');

                if (change < 0) {
                    changeElement
                        .text(`-Rp ${changeFormatted}`)
                        .removeClass('text-green-700')
                        .addClass('text-red-500');
                } else {
                    changeElement
                        .text(`Rp ${changeFormatted}`)
                        .removeClass('text-red-500')
                        .addClass('text-green-700');
                }
            }

            function renderCartItems() {
                const container = $('.stockGroup');
                container.html('');

                if (cartItems.length === 0) {
                    container.html(`
                        <div class="rounded-md border border-gray-200 text-center py-4 italic text-sm tracking-wider text-gray-500">
                            Keranjang Kosong.
                        </div>
                    `);
                } else {
                    cartItems.forEach((item, index) => {
                        const itemHtml = `
                        <div class="stockItem mb-1 flex justify-between items-center" data-index="${index}">
                            <div>
                                <h1 class="text-sm tracking-wider font-semibold">
                                ${item.stockName}
                                </h1>
                                <h2 class="text-xs tracking-wider font-semibold text-gray-400">
                                    Rp ${customFunction.formatNumberToRupiah(item.price)}
                                </h2>
                            </div>
                            <div class="space-x-2">
                                <input type="text" name="sales_quantity[]"
                                    class="number-input quantity-input border-b border-gray-300 outline-none py-2 px-4 rounded-lg w-[100px] focus:border focus:border-blue-500" value="${item.quantity}">
                                <button type="button"
                                    class="delete-item px-2 rounded-lg text-red-500 cursor-pointer active:scale-95 transition duration-200 hover:text-red-600 hover:shadow">
                                    <i class="fa-solid fa-trash text-[14px]"></i>
                                </button>
                            </div>
                        </div>
                    `;

                        container.append(itemHtml);
                    });
                }

                calculateSummary();
            };

            function resetCartItems() {
                cartItems.length = 0;
                $('#sales_payment').val('');
                $('#sales_discount').val(0);
                renderCartItems();
            }
        });
    </script>
@endpush
