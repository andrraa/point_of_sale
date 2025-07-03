<div id="modal-pay" class="fixed inset-0 backdrop-blur-xs bg-gray-500/60 hidden justify-center items-center z-50">

    <div class="bg-white rounded-xl w-[450px] p-3">

        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-black/80 tracking-wide">
                Pembayaran Detail
            </h2>

            <button class="text-lg font-bold text-gray-500 px-2 cursor-pointer modal-pay-cancel">x</button>
        </div>

        <div class="mb-2">
            <h2 class="font-semibold text-black/80 tracking-wide mb-1">Pelanggan</h2>

            <div>
                <label for="" class="font-medium text-sm text-gray-500 tracking-wide block mb-0.5">
                    Nama
                </label>
                <input type="text" id="modal-customer-name"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                    readonly>
            </div>

            <div>
                <label for="" class="font-medium text-sm text-gray-500 tracking-wide">
                    Hutang
                </label>
                <input type="text" id="modal-customer-debt"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                    readonly>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="font-semibold text-black/80 tracking-wide mb-1">Pembayaran</h2>

            <div class="mb-1">
                <label for="" class="font-medium text-sm text-gray-500 tracking-wide block mb-0.5">
                    Total Belanja
                </label>
                <input type="text" id="modal-customer-total"
                    class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                    readonly>
            </div>

            <div class="flex items-center gap-2">
                <div>
                    <label for="" class="font-medium text-sm text-gray-500 tracking-wide">
                        Total Bayar
                    </label>
                    <input type="text" id="modal-customer-pay"
                        class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none price-input">
                </div>

                <div>
                    <label for="" class="font-medium text-sm text-gray-500 tracking-wide">
                        Total Kembalian
                    </label>
                    <input type="text" id="modal-customer-change"
                        class="text-black/80 font-semibold tracking-wide px-4 py-1.5 rounded-lg border border-gray-300 shadow-sm text-sm w-full outline-none"
                        readonly>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                class="modal-pay-cancel w-full py-1.5 text-sm border border-gray-300 rounded-lg text-black/80 tracking-wide font-semibold cursor-pointer hover:bg-gray-100 transition-colors duration-300">
                Batal
            </button>
            <button id="modal-pay-confirm"
                class="w-full py-1.5 text-sm bg-blue-500 rounded-lg text-white tracking-wide font-semibold cursor-pointer hover:bg-blue-600 transition-colors duration-300">
                Bayar
            </button>
        </div>
    </div>
</div>
