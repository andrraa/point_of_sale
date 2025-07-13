<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kasir - Point of Sale</title>

    @vite('resources/css/app.css')

    <style>
        @media print {
            body * {
                visibility: hidden !important;
                margin: 0;
            }

            #modal-container,
            #modal-container * {
                visibility: visible !important;
            }

            #modal-container {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 75mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
                display: block !important;
            }

            #modal-card {
                all: unset;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="h-dvh bg-gray-200 flex flex-col pb-4">
    {{-- DATETIME --}}
    <div class="px-4 pt-3 pb-1 flex items-center gap-4">
        <div class="bg-white shadow-lg border flex items-center gap-2 rounded-full py-1 px-2 border-gray-200">
            <div class="bg-blue-500 w-6 h-6 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-user text-white"></i>
            </div>

            <div>
                <h1 class="text-sm font-medium tracking-wider text-blue-500 capitalize">
                    {{ Session::get('user')['full_name'] }}
                </h1>
            </div>
        </div>

        <div class="h-12 bg-blue-500 relative flex items-center justify-between px-4 shadow-lg rounded-xl grow">
            <div>
                <h1 class="font-bold uppercase text-white/80 tracking-wide">
                    {{ $store->store_name }} # Telp: {{ $store->store_phone_number }}
                </h1>
            </div>

            <div>
                <span id="datetime" class="font-bold text-white/80 tracking-wide"></span>
            </div>
        </div>
    </div>

    {{-- TOTAL AND LOGO --}}
    <div class="h-32 w-full mt-2 px-4">
        {{-- TOTAL PRICE --}}
        <div class="h-full bg-black/90 rounded-xl shadow-lg flex items-center justify-between px-8">
            <div>
                <span class="text-white/80 text-2xl font-bold tracking-wide">
                    TOTAL :
                </span>
            </div>

            <div>
                <span id="total-price" class="text-orange-300 text-[50px] font-bold tracking-wide">
                </span>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="h-[calc(100%-200px)] mt-4 px-4 flex gap-4 overflow-hidden">
        <div class="h-full flex-grow min-w-[400px] max-w-[calc(100%-400px)]">
            <div class="flex items-center gap-4 bg-white/80 p-3 rounded-xl shadow-lg">
                <div class="w-1/3 flex items-center gap-2">
                    <label for="stock_code" class="font-medium uppercase text-sm">Kode</label>

                    <x-form.input :props="[
                        'id' => 'stock_code',
                        'name' => 'stock_code',
                        'value' => null,
                        'placeholder' => 'Scan / Masukkan Kode Produk',
                        'class' => '!border-2 focus:!border-2 !py-1.5',
                    ]" />
                </div>

                <div class="flex items-center gap-2 w-1/3">
                    <label for="stock_code" class="font-medium uppercase text-sm">Pelanggan</label>

                    <x-form.select :props="[
                        'id' => 'cart_customer',
                        'name' => 'cart_customer',
                        'class' => 'w-full',
                        'value' => null,
                    ]" :options="$customers" />
                </div>

                <div class="w-1/3 bg-black py-2.5 px-3 flex items-center justify-between rounded-md">
                    <span class="text-sm uppercase text-white/80 font-bold">Hutang :</span>
                    <span id="total-debt" class="text-orange-300 font-bold">0</span>
                </div>
            </div>

            <div class="mt-4 bg-white shadow-lg h-full overflow-y-auto rounded-xl">
                <table id="product-table" class="min-w-full table">
                    <thead
                        class="text-[13px] text-left border-t border-b border-t-gray-300 border-b-gray-300 bg-gray-100">
                        <tr>
                            <th class="p-2 w-[100px] uppercase tracking-wide">Kode</th>
                            <th class="p-2 uppercase tracking-wide">NAMA PRODUK</th>
                            <th class="p-2 w-[90px] uppercase tracking-wide">JUMLAH</th>
                            <th class="p-2 w-[90px] uppercase tracking-wide">HARGA</th>
                            <th class="p-2 w-[90px] uppercase tracking-wide">DISKON %</th>
                            <th class="p-2 w-[90px] uppercase tracking-wide">TOTAL</th>
                            <th class="p-2 w-[50px]"></th>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] text-left">
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ACTION BUTTON --}}
        @php
            $buttons = [
                ['id' => 'fullscreen-button', 'label' => 'Fullscreen (F1)'],
                ['id' => 'scan-button', 'label' => 'Pindai (F2)'],
                ['id' => 'calculate-button', 'label' => 'Hitung (F3)'],
                ['id' => 'discount-button', 'label' => 'Cek Hutang (F4)'],
                ['id' => 'reset-button', 'label' => 'Reset (F5)'],
                ['id' => 'pay-button', 'label' => 'Bayar (F6)'],
            ];
        @endphp

        <div class="max-h-full w-full max-w-1/3">
            @foreach (array_chunk($buttons, 2) as $row)
                <div class="flex items-center gap-3 mb-3">
                    @foreach ($row as $button)
                        <div id="{{ $button['id'] }}"
                            class="h-24 w-full bg-blue-500 text-white font-semibold uppercase rounded-xl shadow-lg hover:bg-blue-600 transition-colors duration-300 flex items-center justify-center cursor-pointer tracking-wide">
                            {{ $button['label'] }}
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="flex items-center gap-3">
                @php
                    $user = Auth::user();
                    $isAdmin = $user->user_role_id == \App\Models\Role::ROLE_ADMIN;
                @endphp

                @if ($isAdmin)
                    <a href="{{ route('dashboard') }}"
                        class="h-24 w-full bg-blue-500 text-white font-semibold tracking-wide uppercase flex items-center justify-center cursor-pointer rounded-xl shadow-lg transiton-colors duration-300 hover:bg-blue-600">
                        Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="h-24 w-full bg-red-500 text-white font-semibold tracking-wide uppercase rounded-xl flex items-center justify-center cursor-pointer shadow-lg hover:bg-red-600 transition-colors duration-300">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- PAY MODAL --}}
    @include('cashier.v2.modal')

    {{-- MODAL PRINT --}}
    <div id="modal-container"
        class="fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full items-center justify-center hidden">
        <div id="modal-card"
            class="relative mx-auto p-4 border border-gray-300 w-full max-w-[400px] shadow-lg rounded-lg bg-white">
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/function.js'])

    <script type="module">
        $(document).ready(function() {
            const customFunction = window.CustomFunction;

            $('.price-input').on('input',
                function() {
                    this.value = customFunction.formatNumberToRupiah(this.value);
                });

            // SELETCT2
            $('.select2').select2({
                placeholder: 'Pilih salah satu opsi',
            });

            // AJAX SETUP
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // START CART
            let cart = [];
            let debt = 0;
            let total = 0;
            let change = 0;

            $('#stock_code').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    const code = $(this).val().trim();
                    const customerId = $('#cart_customer').val();

                    if (code !== '') {
                        searchProduct(code, customerId);
                    }
                }
            });

            $('#cart_customer').on('change', function() {
                resetAll();
                focusStockCode();
            });

            $(document).on('click', '.delete-product', function() {
                deleteRow(this);
            });

            $(document).on('input', '.quantity-input', function() {
                const code = $(this).data('code');
                const item = cart.find(p => p.code == code);
                if (!item) return;

                let newQty = parseInt($(this).val());
                if (isNaN(newQty) || newQty < 1) {
                    newQty = 1;
                }

                item.quantity = newQty;

                const subtotal = item.price * item.quantity * (1 - item.discount / 100);
                $(this).closest('tr').find('.total-cell').text(subtotal.toLocaleString());

                calculatePrice();
            });

            $(document).on('input', '.discount-input', function() {
                const code = $(this).data('code');
                const item = cart.find(p => p.code == code);
                if (!item) return;

                const newDiscount = parseInt($(this).val());
                if (newDiscount > 100) {
                    $(this).val(100);
                    item.discount = 100;
                } else if (newDiscount < 0) {
                    $(this).val(0);
                    item.discount = 0;
                } else {
                    item.discount = newDiscount;
                }

                const subtotal = item.price * item.quantity * (1 - item.discount / 100);
                $(this).closest('tr').find('.total-cell').text(subtotal.toLocaleString());

                calculatePrice();
            });

            function searchProduct(code, customerId) {
                $.ajax({
                    url: '{{ route('cashier.get-item') }}',
                    type: 'POST',
                    data: {
                        code: code,
                        customer: customerId
                    },
                    success: function(response) {
                        if (response.success) {
                            const item = response.data;
                            const existItem = cart.find(p => p.code === item.code);

                            if (existItem) {
                                existItem.quantity += item.quantity;

                                if (existItem.quantity > item.max_quantity) {
                                    existItem.quantity = item.max_quantity;
                                }

                                const $row = $('#product-table tbody tr').filter(function() {
                                    return $(this).find('td').eq(0).text().trim() === item.code;
                                });

                                $row.find('.quantity-input').val(existItem.quantity);
                            } else {
                                $('#product-table tbody').append(`
                                    <tr>
                                        <td class="p-2 tracking-wide">${item.code}</td>
                                        <td class="p-2 tracking-wide">${item.name}</td>
                                        <td class="p-2 tracking-wide">
                                            <input type="number" class="quantity-input w-16 text-right p-1 rounded-sm border border-gray-200" 
                                                data-code="${item.code}" min="1" max="${item.max_quantity}" value="${item.quantity}">
                                        </td>
                                        <td class="p-2 tracking-wide">${item.price.toLocaleString()}</td>
                                        <td class="p-2 tracking-wide">
                                            <input type="number" class="discount-input w-16 text-right p-1 rounded-sm border border-gray-200" 
                                                data-code="${item.code}" min="0" max="100" value="${item.discount}">
                                        </td>
                                        <td class="p-2 tracking-wide total-cell">${(item.price * item.quantity).toLocaleString()}</td>
                                        <td class="p-2">
                                            <button class="delete-product cursor-pointer">
                                                <i class="fa-solid fa-times text-red-500"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `);

                                cart.push(response.data);
                            }
                        } else {
                            errorAlert(response.message);
                        }

                        calculatePrice();
                        focusStockCode();
                    },
                    error: function(xhr) {
                        errorAlert('Server error!.');
                    }
                });
            }

            function calculatePrice() {
                total = cart.reduce((sum, item) => {
                    const discountFactor = (100 - item.discount) / 100;
                    const effectivePrice = item.price * discountFactor;

                    const subtotal = effectivePrice * item.quantity;
                    return sum + subtotal;
                }, 0);

                $('#total-price').text(total.toLocaleString());
            }

            function resetAll() {
                cart = [];
                debt = 0;
                $('#product-table tbody').empty();
                $('#total-debt').text('0');
                calculatePrice();
                focusStockCode();
            }

            function deleteRow(button) {
                const $row = $(button).closest('tr');

                const kodeProduk = $row.find('td').eq(0).text().trim();

                $row.remove();

                cart = cart.filter(item => item.code !== kodeProduk);

                calculatePrice();

                focusStockCode();
            }

            calculatePrice();
            // END CART

            // START DATETIME NAVBAR
            function updateDateTime() {
                const now = new Date();
                const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                const dayName = days[now.getDay()];

                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();

                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                const dateStr = `${dayName}, ${day} ${getMonthName(now.getMonth())} ${year}`;
                const timeStr = `${hours}:${minutes}:${seconds}`;

                $('#datetime').text(`${dateStr} ${timeStr}`);
            }

            function getMonthName(idx) {
                const months = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                return months[idx];
            }

            setInterval(updateDateTime, 1000);

            updateDateTime();
            // END DATETIME NAVBAR

            // START FOCUS TO STOCK CODE
            $('#stock_code').on('blur', function() {
                if ($('#modal-pay').hasClass('hidden')) {
                    setTimeout(function() {
                        focusStockCode();
                    }, 10000);
                }
            });

            function focusStockCode() {
                $('#stock_code').val('').focus();
            }

            focusStockCode();
            // END FOCUS TO STOCK CODE

            // START FULLSCREEN
            function toggleFullscreen() {
                const el = document.documentElement;

                if (!document.fullscreenElement) {
                    if (el.requestFullscreen) {
                        el.requestFullscreen();
                    } else if (el.webkitRequestFullscreen) {
                        el.webkitRequestFullscreen();
                    } else if (el.msRequestFullscreen) {
                        el.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }

                focusStockCode();
            }

            $('#fullscreen-button').on('click', function() {
                toggleFullscreen();
                focusStockCode();
            });
            // END FULLSCREEN

            // START CEK HUTANG
            function checkDebt() {
                const customerId = $('#cart_customer').val();

                if (customerId == 1) {
                    successAlert('Pelanggan Umum tidak memiliki Hutang!.');
                    return;
                }

                $.ajax({
                    url: "{{ route('cashier.get-credit') }}",
                    type: "POST",
                    data: {
                        customerId: customerId
                    },
                    success: function(response) {
                        const message = response.debt == 0 ?
                            'tidak memiliki hutang.' :
                            `Memiliki hutang ${response.debt}`;

                        if (response.debt > 0) {
                            debt = response.debt;
                        }

                        console.log(debt);

                        $('#total-debt').text(debt.toLocaleString());

                        successAlert(`Pelanggan ${message}`);
                    },
                    error: function(xhr) {
                        errorAlert('Terjadi kesalahan server!.');
                    }
                });
            }
            // END CEK HUTANG

            // START PAYMENT
            function payment() {
                if (cart.length === 0) {
                    errorAlert('Keranjang kosong!');
                    return
                }

                $('#modal-customer-name').val($('#cart_customer option:selected').text().trim());
                $('#modal-customer-debt').val('Rp ' + debt.toLocaleString());
                $('#modal-customer-total').val('Rp ' + total.toLocaleString());
                $('#modal-customer-change').val('Rp ' + change.toLocaleString());

                openModal();

                $('#modal-customer-pay').val('').focus();
            }

            function openModal() {
                $('#modal-pay').removeClass('hidden').addClass('flex');
            }

            function closeModal() {
                $('#modal-pay').removeClass('flex').addClass('hidden');
            }

            $('.modal-pay-cancel').on('click', function() {
                closeModal();
                focusStockCode();
            });

            $('#modal-customer-pay').on('blur', function() {
                if ($('#modal-pay').hasClass('flex')) {
                    $('#modal-customer-pay').focus();
                }
            });

            $('#modal-customer-pay').on('input', function() {
                var payInput = $(this).val();

                var payAmount = parseFloat(payInput.replace(/\./g, '').replace(',', '.') || 0);

                var payChange = 0;

                if (payAmount >= (total + debt)) {
                    payChange = payAmount - (total + debt);
                } else {
                    payChange = payAmount - total;
                }

                if (isNaN(payChange)) payChange = 0;

                $('#modal-customer-change').val('Rp ' + payChange.toLocaleString());
            });

            $('#modal-pay-confirm').on('click', function() {
                var payInput = $('#modal-customer-pay').val();
                var payAmount = parseFloat(payInput.replace(/\./g, '').replace(',', '.') || 0);

                if (!payInput) {
                    errorAlert('Jumlah uang tidak boleh kosong.');
                    return;
                }

                var customerId = parseInt($('#cart_customer').val());

                if (payAmount < total) {
                    var tmpDebt = total - payAmount;

                    if (customerId !== 1) {
                        Swal.fire({
                            title: 'Pembayaran Kurang',
                            text: `Kurang Rp ${tmpDebt.toLocaleString()}. Akan dijadikan hutang.`,
                            icon: 'warning',
                            showCancelButton: true,
                            cancelButtonText: 'Batal'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                submitPayment(customerId, payAmount, debt, cart);
                            }
                        });
                    } else {
                        errorAlert(`Jumlah uang pembayaran kurang Rp ${tmpDebt.toLocaleString()}.`);
                    }
                } else {
                    submitPayment(customerId, payAmount, debt, cart);
                }
            });

            function submitPayment(customerId, customerPay, customerDebt, items) {
                $.ajax({
                    url: "{{ route('cashier.checkout') }}",
                    type: "POST",
                    data: {
                        customerId: customerId,
                        customerPay: customerPay,
                        customerDebt: customerDebt,
                        items: items,
                    },
                    success: function(response) {
                        closeModal();
                        successAlert('Pembayaran berhasil!.');
                        print(response.id);
                        setTimeout(function() {
                            resetAll();
                        }, 1000);
                    },
                    error: function(xhr) {
                        errorAlert('Terjadi kesalahan server.');
                    }
                });
            }
            // END PAYMENT

            // LISTENER KEYDOWN (F ROW)
            $(document).on('keydown', function(e) {
                if (e.which === 112) {
                    // F1
                    e.preventDefault();
                    toggleFullscreen();
                } else if (e.which === 113) {
                    // F2
                    e.preventDefault();
                    focusStockCode();
                } else if (e.which === 114) {
                    // F3
                    e.preventDefault();
                    calculatePrice();
                } else if (e.which === 115) {
                    // F4
                    e.preventDefault();
                    checkDebt();
                } else if (e.which === 116) {
                    // F5
                    e.preventDefault();
                    resetAll();
                } else if (e.which === 117) {
                    // F6
                    e.preventDefault();
                    payment();
                }
            });
            // END LISTENER (F ROW)

            function errorAlert(message) {
                customAlert(message, 'error');
            }

            function successAlert(message) {
                customAlert(message, 'success');
            }

            function customAlert(message, icon) {
                Swal.fire({
                    title: icon === 'error' ? 'Error' : 'Sukses',
                    text: message,
                    icon: icon,
                    timer: 1000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }

            // PRINT INVOICE
            const modalCard = $('#modal-card');
            const modalContainer = $('#modal-container');

            function print(salesId) {
                $.ajax({
                    url: `/sale/${salesId}`,
                    type: "GET",
                    success: function(res) {
                        modalCard.html(res);
                        modalContainer.removeClass('hidden').addClass('flex');
                        setTimeout(() => {
                            window.print();
                        }, 100);
                    }
                });
            }

            $(document).on('click', '#cancel-print-button', function() {
                $('#modal-container').addClass('hidden').removeClass('flex');
                $('#modal-card').html('');
            });

            $(document).on('click', '#print-button', function() {
                window.print();
            });
        });
    </script>
</body>

</html>
