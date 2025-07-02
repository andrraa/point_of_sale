<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasir - Point of Sale</title>
    @vite('resources/css/app.css')
</head>

<body class="h-dvh bg-gray-200 flex flex-col">
    {{-- DATETIME --}}
    <div class="h-12 w-full bg-blue-900 relative flex items-center justify-between px-4">
        <div>
            <h1 class="font-bold uppercase text-white/80 tracking-wide">
                {{ $store->store_name }} # Telp: {{ $store->store_phone_number }}
            </h1>
        </div>

        <div>
            <span id="datetime" class="font-bold text-white/80 tracking-wide"></span>
        </div>
    </div>

    {{-- TOTAL AND LOGO --}}
    <div class="h-32 w-full flex gap-2 mt-2 px-2">
        {{-- LOGO --}}
        <div class="w-1/7 h-full rounded-sm flex items-center justify-center border border-gray-400 bg-black/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 16 16">
                <path class="fill-white/80"
                    d="M12.5 2A2.5 2.5 0 0 1 15 4.5v10a.5.5 0 0 1-.686.464l-2.31-.926l-2.31.926a.5.5 0 0 1-.28.027l-.092-.027l-2.31-.926l-2.31.926a.5.5 0 0 1-.678-.378l-.007-.086V7.36l-.985-.328l-2.33.932a.5.5 0 0 1-.678-.378L.017 7.5v-3a2.5 2.5 0 0 1 2.5-2.5h10zm0 1h-8l.019.024c.303.413.482.923.482 1.48v9.26l1.81-.725a.5.5 0 0 1 .28-.027l.091.027l2.31.925l2.32-.925a.5.5 0 0 1 .28-.027l.092.027l1.81.725v-9.26c0-.78-.595-1.42-1.36-1.49l-.144-.007zm-3 6a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1zm3-2a.5.5 0 0 1 0 1h-6a.5.5 0 0 1 0-1zm-10-4l-.144.007a1.503 1.503 0 0 0-1.36 1.49v2.26l1.81-.725a.5.5 0 0 1 .258-.03l.086.02l.842.28v-1.81c0-.78-.595-1.42-1.36-1.49l-.144-.007zm10 2a.5.5 0 0 1 0 1h-6a.5.5 0 0 1 0-1z" />
            </svg>
        </div>

        {{-- TOTAL PRICE --}}
        <div class="w-full h-full bg-black/90 rounded-sm flex items-center justify-between px-8">
            <div>
                <span class="text-white/80 text-2xl font-bold tracking-wide">
                    TOTAL :
                </span>
            </div>

            <div>
                <span class="text-orange-300 text-[50px] font-bold tracking-wide">
                    1.750.000
                </span>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="h-[calc(100%-200px)] mt-2 px-2 flex gap-4 overflow-hidden">
        <div class="h-full w-2/3">
            <div class="flex items-center gap-2">
                <label for="stock_code" class="font-bold">KODE #</label>
                <input type="text" id="stock_code" name="stock_name"
                    class="bg-blue-900 px-2 py-1 focus:outline-blue-900 font-medium rounded-sm text-sm tracking-wider text-white w-[300px]"
                    autofocus placeholder="Pindai Kode Produk">
            </div>

            <div class="mt-[10px] bg-white shadow-lg h-[470px] overflow-y-auto rounded-sm">
                <table id="product-table" class="w-full table">
                    <thead
                        class="text-[13px] text-left border-t border-b border-t-gray-300 border-b-gray-300 bg-gray-100">
                        <tr>
                            <th class="p-1 w-[100px] uppercase tracking-wide">Kode</th>
                            <th class="p-1 uppercase tracking-wide">NAMA PRODUK</th>
                            <th class="p-1 w-[90px] uppercase tracking-wide">JUMLAH</th>
                            <th class="p-1 w-[90px] uppercase tracking-wide">HARGA</th>
                            <th class="p-1 w-[90px] uppercase tracking-wide">DISKON</th>
                            <th class="p-1 w-[90px] uppercase tracking-wide">TOTAL</th>
                            <th class="p-1 w-[30px]"></th>
                        </tr>
                    </thead>
                    <tbody class="text-[13px] text-left">
                        @for ($i = 0; $i < 10; $i++)
                            <tr class="border-b border-b-gray-300">
                                <td class="p-1 tracking-wide">100025</td>
                                <td class="p-1 tracking-wide">BAJU SETELAN ANAK KECIL PANJANG</td>
                                <td class="p-1 tracking-wide">2 pcs</td>
                                <td class="p-1 tracking-wide">30.000</td>
                                <td class="p-1 tracking-wide">0</td>
                                <td class="p-1 tracking-wide">60.000</td>
                                <td class="p-1">
                                    <button class="delete-product cursor-pointer">
                                        <i class="fa-solid fa-times text-red-500"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="max-h-full w-full max-w-1/3 mt-10">
            <div class="flex items-center gap-3 mb-3">
                <div id="fullscreen-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Fullscreen (F1)
                </div>

                <div id="scan-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Pindai (F2)
                </div>
            </div>

            <div class="flex items-center gap-3 mb-3">
                <div id="calculate-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Hitung (F6)
                </div>

                <div id="discount-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Diskon (F7)
                </div>
            </div>

            <div class="flex items-center gap-3 mb-3">
                <div id="reset-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Reset (F8)
                </div>

                <div id="pay-button"
                    class="h-24 w-full bg-blue-900 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Bayar (F9)
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div id="reset-button"
                    class="h-24 w-full bg-blue-500 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Admin
                </div>

                <div id="pay-button"
                    class="h-24 w-full bg-red-500 text-white font-medium uppercase rounded-lg flex items-center justify-center cursor-pointer">
                    Keluar
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')

    <script type="module">
        $(document).ready(function() {
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

            // FOCUS TO STOCK CODE
            function focusStockCode() {
                $('#stock_code').focus();
            }

            // BUTTON FULLSCREEN
            $('#fullscreen-button').on('click', function() {
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
            });
        });
    </script>
</body>

</html>
